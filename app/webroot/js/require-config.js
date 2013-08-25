requirejs.config({
    "paths": {
        "bootstrap":            "vendor/bootstrap.min",
        "bootstrap-tab":        "vendor/bootstrap/bootstrap-tab",
        "bootstrap-tooltip":    "vendor/bootstrap/bootstrap-tooltip",
        "bootstrap-dropdown":   "vendor/bootstrap/bootstrap-dropdown",
        "bootstrap-button":     "vendor/bootstrap/bootstrap-button",
        "bootstrap-alert":      "vendor/bootstrap/bootstrap-alert",
        "bootstrap-transition": "vendor/bootstrap/bootstrap-transition",
        "bootstrap-affix":      "vendor/bootstrap/bootstrap-affix",
        "bootstrap-collapse":   "vendor/bootstrap/bootstrap-collapse",
        "bootstrap-modal":      "vendor/bootstrap/bootstrap-modal",
        "jquery":               "vendor/jquery-1.10.2.min",
        "ko":                   "vendor/knockout-2.3.0",
        "datepicker":           "vendor/jquery-ui-custom/js/jquery-ui-1.10.2.custom.min",
        "jquery-ui":            "vendor/jquery-ui-custom/js/jquery-ui-1.10.2.custom.min",
        "jquery-ui-full":       "vendor/jquery-ui-custom-full/js/jquery-ui.custom.min",
        "block-ui":             "vendor/jquery.blockUI",
        "dataTables":           "vendor/dataTables/media/js/jquery.dataTables.min"
    },
    "shim":  {
        "datepicker":           {
            "deps": ["jquery", "vendor/jquery-ui-custom/js/jquery.ui.datepicker-de"]
        },
        "bootstrap":            {
            "deps": ["jquery"]
        },
        "dataTables":           {
            "deps": ["jquery"]
        },
        "jquery-ui":            {
            "deps": ["jquery"]
        },
        "jquery-ui-full":       {
            "deps": ["jquery"]
        },
        "block-ui":             {
            "deps": ["jquery"]
        },
        "bootstrap-tooltip":    {
            "deps": ["jquery"]
        },
        "bootstrap-tab":        {
            "deps": ["jquery"]
        },
        "bootstrap-affix":      {
            "deps": ["jquery"]
        },
        "bootstrap-button":     {
            "deps": ["jquery"]
        },
        "bootstrap-alert":      {
            "deps": ["jquery"]
        },
        "bootstrap-dropdown":   {
            "deps": ["jquery", "bootstrap-transition"]
        },
        "bootstrap-collapse":   {
            "deps": ["jquery", "bootstrap-transition"]
        },
        "bootstrap-modal":      {
            "deps": ["jquery", "bootstrap-transition"]
        },
        "bootstrap-transition": {
            "deps": ["jquery"]
        }
    }
});