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
        source: 'user-lists',
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
          width: 50,
          type: 'number',
          selector: false,
          textAlign: 'center',
        }, {
          field: 'email',
          title: '邮箱',
        }, {
          field: 'name',
          title: '用户名',
        }, {
          field: 'register_at',
          title: '注册时间',
          type: 'date',
          sortable: false,
          format: 'MM/DD/YYYY',
        }, {
          field: 'Actions',
          title: '操作',
          sortable: false,
          width: 110,
          overflow: 'visible',
          autoHide: false,
          template: function () {
            return '\
						<div class="dropdown">\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" data-toggle="dropdown">\
                                <i class="flaticon2-gear"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
						  	</div>\
						</div>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit details">\
							<i class="flaticon2-paper"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Delete">\
							<i class="flaticon2-trash"></i>\
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
