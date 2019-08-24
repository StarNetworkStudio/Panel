"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {

		var datatable = $('.kt_datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: 'user-list.json',
				pageSize: 10,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch')
			},

			// columns definition
			columns: [
				{
					field: 'uid',
					title: 'UID',
					width: 55,
					type: 'number',
					textAlign: 'center',
				}, {
					field: 'email',
					title: '邮箱',
				}, {
					field: 'name',
					title: '用户名',
				}, {
					field: 'permission',
					title: '权限',
          template: function(row) {
            var permission = {
              '-1': {'title': '封禁'},
              0: {'title': '普通用户'},
              1: {'title': '管理员'},
              2: {'title': '超级管理员'},
            };
            return permission[row.permission].title;
          },
				}, {
					field: 'register_at',
					title: '注册时间',
					type: 'date',
					format: 'MM/DD/YYYY',
				}, {
					field: '操作',
					title: '操作',
					sortable: false,
					width: 110,
					autoHide: false,
					overflow: 'visible',
					template: function() {
						return '\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
					},
				}],

		});

    $('#kt_form_status').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#kt_form_type').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'type');
    });

    $('#kt_form_status,#kt_form_type').selectpicker();

	};

	return {
		// public functions
		init: function () {
			demo();
		}
	};
}();

jQuery(document).ready(function () {
	KTDatatableJsonRemoteDemo.init();
});
