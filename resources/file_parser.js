var fs = require('fs');

fs.readdir('veranstaltungen/', function (err, files) {
	var sql = '';
	var done = files.length;

	for (var i = 0; i < files.length; i += 1) {
		(function (file) {
			var importer = new Importer('veranstaltungen/' + files[i]);
			importer.read(function (data) {
				importer.parser(data, function (fileSQL) {
					sql += fileSQL;
					done -= 1;
					if (done <= 0) {
						fs.writeFileSync('export.sql', sql);
					}
				});
			});
		}(files[i]));
	};
});

function Importer(file) {
	this.file = file;
	this.sql = '';
}

Importer.prototype.read = function(callback) {
	var self = this;

	fs.readFile(this.file, { encoding: 'binary', flag: 'r' }, function (err, data) {
		if (err) throw err;
		callback(data);
	});
};

Importer.prototype.parser = function(data, callback) {
	var lines = data.split('\r\n');
	var term = '';
	var category = '';

	// Ganz normaler Parser mit Schleife und Switch + look-ahead 1
	for (var i = 0; i < lines.length; i++) {
		var line = lines[i];

		if (String(line).trim() === '') {
			continue;
		}
		var c = String(line[0]).trim().toLowerCase();

		// Kommentar
		if (c === '#') {
			continue;
		}
		// Semester
		else if (c === 'z' && line.split('=')[0].trim().toLowerCase() == 'zeitraum') {
			term = String(line.split('=')[1]).trim();
			this.sql += SQLCompiler.insert.term(term);
		}
		// Kategorie
		else if (c === '@') {
			category = String(line.slice(1, line.length)).trim();
			this.sql += SQLCompiler.insert.category(category);

			// Gruppierung der nachfolgenden Zeilen unter der Kategorie
			for (var j = ++i; j < lines.length; j++) {
				if (lines[j][0]) {
					var local_c = String(lines[j]).trim()[0];

					// Eine Zeile zurück, neue Kategorie
					if (local_c === '@') {
						i = --j;
						break;
					}
					// Kommentar
					// else if (local_c === '#') {
					// 	continue;
					// }
					// Gültige Zeile
					else {
						// Wir ziehen auskommentierte Kurse mit rein.
						if (local_c === '#' && lines[j][1] !== '@') {
							var course = lines[j].slice(1, lines[j].length).split(';');
						}
						else {
							var course = lines[j].split(';');
						}
						var course = {
						    code:  String(course[0]).trim(),
							name:  String(course[1]).trim(),
							date:  String(course[2]).trim(),
							hours: String(course[3]).trim(),
							max:   parseInt(course[4], 10) || 0
						}
						// Ungültige Zeile aus welchen Gründen auch immer.
						if (course.name === 'undefined') {
							continue;
						}
						// Wenn beim Datum und der Zeit 'siehe unten' steht nehemen
						// wir diese Werte von der nächsten Zeile.
						if (lines[j].toLowerCase().indexOf('siehe unten') !== -1) {
							var nextLine = j + 1;
							var nextLineData = lines[nextLine].split(';');
							course.date = String(nextLineData[2]).trim();
							course.hours = String(nextLineData[3]).trim();
							course.max = parseInt(nextLineData[4], 10) || 10;
						}

						var category_id =  SQLCompiler.select.category_id(category);
						this.sql += SQLCompiler.insert.course(category_id, course.name, course.code);

						var term_id = SQLCompiler.select.term_id(term);
						var course_id = SQLCompiler.select.course_id(course.code);
						
						this.sql += SQLCompiler.insert.courses_terms(term_id, course_id, course.max);
						
						var courses_term_id = SQLCompiler.select.courses_term_id(term_id, course_id);
						
						var days = course.date.split('+');
						for (var k = 0; k < days.length; k++) {
							var day = {
								start_date: this.getDate(days[k]),
								start_time: this.getTime(course.hours).start_time,
								end_time:   this.getTime(course.hours).end_time,
							}
							this.sql += SQLCompiler.insert.day(courses_term_id, day.start_date, day.start_time, day.end_time);
						}
					}
				}
			};
		}
	};
	callback(this.sql);
};

Importer.prototype.getDate = function(rawDate) {
	var date = rawDate.split('.');
	var day   = parseInt(date[0], 10);
	var month = parseInt(date[1], 10);
	var year  = parseInt(date[2], 10);
	
	day = (day < 10) ? ('0' + day) : day;
	month = (month < 10) ? ('0' + month) : month;
	year = (year < 10) ? ('0' + year) : year;

	if (String(year).length === 2) {
		year = '20' + year;
	}

	return year + '-' + month + '-' + day;
};

Importer.prototype.getTime = function(rawTime) {
	var a = rawTime.split('-');
	var startInt = parseInt(a[0], 10);
	var endInt = parseInt(a[1], 10);

	return {
		start_time: ((startInt < 10) ? '0' + startInt : startInt) + ':00:00',
		end_time:   ((endInt < 10) ? '0' + endInt : endInt) + ':00:00',
	}
};

var SQLCompiler = {
	insert: {
		term: function (name) {
			return "INSERT IGNORE INTO terms (name,start,end) VALUES ('"+name+"', '0000-00-00', '0000-00-00');\n"
		},
		category: function (name) {
			return "INSERT IGNORE INTO categories (name) VALUES ('"+name+"');\n";
		},
		course: function (category_id, name, code) {
			return "INSERT IGNORE INTO courses (category_id, name, code) VALUES ("+ category_id +", '"+name+"', '"+code+"');\n"
		},
		day: function (courses_term_id, start_date, start_time, end_time) {
			return "INSERT IGNORE INTO days (courses_term_id, start_date, start_time, end_time) VALUES ("+ courses_term_id +", '"+start_date+"', '"+start_time+"', '"+end_time+"');\n";
		},
		courses_terms: function (term_id, course_id, max) {
			return "INSERT IGNORE INTO courses_terms (term_id, course_id, max, schedule_name) VALUES ("+ term_id +", "+ course_id +", "+ max +", 'unknown');\n";
		}
	},
	select: {
		term_id: function (name) {
			return "(SELECT id FROM terms WHERE name = '" + name + "')";
		},
		category_id: function (name) {
			return "(SELECT id FROM categories WHERE name = '" + name + "')";
		},
		course_id: function (code) {
			return "(SELECT id FROM courses WHERE code = '"+ code + "')";
		},
		courses_term_id: function (term_id, course_id) {
			return "(SELECT id FROM courses_terms WHERE term_id = " + term_id + " AND course_id = "+ course_id +")";
		}
	}
}