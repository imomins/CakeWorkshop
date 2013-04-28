define([
    'jquery',
    'handlebars',
    'text!templates/courses_by_category.html'
], function ($, Handlebars, source) {
    "use strict";

    function Booking(params) {
        this.id = params.id;
    }

    Booking.prototype.all = function (params) {
        $.ajax({
            type:     'POST',
            dataType: 'json',
            url:      CAKEWORKSHOP.webroot + CAKEWORKSHOP.controller + '/' + CAKEWORKSHOP.action + '.json',
            data:     {CoursesTerm: {id: +params.id}},
            success:  function (response) {
                if (typeof params.success === 'function') {
                    params.success({categories: response.coursesByCategory});
                }
            },
            error:    function (response) {
                if (typeof params.error === 'function') {
                    params.error('Fehler: ' + $.parseJSON(response.responseText).name);
                }
            }
        });
    };

    Booking.prototype.save = function (params) {
        $.ajax({
            type:    'POST',
            url:     CAKEWORKSHOP.webroot + 'bookings/add.json',
            data:    {CoursesTerm: params.CoursesTerm, Invoice: {id: +params.Invoice.id}},
            success: params.success,
            error:   params.error
        });
    };

    Booking.prototype.remove = function (params) {
        $.ajax({
            type:    'POST',
            url:     CAKEWORKSHOP.webroot + 'bookings/delete.json',
            data:    {CoursesTerm: {id: +params.id}},
            success: function (response) {
                if (typeof params.success === 'function') {
                    params.success(response);
                }
            },
            error:   function (response) {
                if (typeof params.error === 'function') {
                    params.error(JSON.parse(response.responseText));
                }
            }
        });
    };

    Booking.prototype.toHtml = function (data) {
        var template = Handlebars.compile(source);
        return template(data);
    };

    Booking.prototype.render = function (params) {
        var that = this, id = this.id;

        if (params && params.id) {
            id = params.id;
        }

        this.all({
            success: function (data) {
                document.getElementById(id).innerHTML = that.toHtml(data);

                if (params && typeof params.success === 'function') {
                    params.success();
                }
            },
            error:   function (error) {
                if (params.error && typeof params.error === 'function') {
                    params.error(error);
                }
            }
        });
    };

    return Booking;
});