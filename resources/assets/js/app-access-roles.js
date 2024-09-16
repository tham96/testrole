/**
 * App user list
 */

'use strict';

// Datatable (jquery)
$(function () {
  var dtUserTable = $('.datatables-users'),
    dt_User

  var userView = baseUrl + 'app/user/view/account';

  // Users List datatable
  if (dtUserTable.length) {
    var dtUser = dtUserTable.DataTable({
      ajax: assetsPath + 'json/role-list.json', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: 'role' },
        { data: 'display_name' },
        { data: 'description' },
        { data: '' }
      ],
      columnDefs: [
        {
          // User Role
          targets: 0,
          render: function (data, type, full, meta) {
            var $role = full['name'];
            var roleBadgeObj = {
              Author: '<i class="ti ti-crown ti-md text-primary me-2"></i>',
              Test: '<i class="ti ti-edit ti-md text-warning me-2"></i>',
              User: '<i class="ti ti-user ti-md text-success me-2"></i>',
              Support: '<i class="ti ti-chart-pie ti-md text-info me-2"></i>',
              Admin: '<i class="ti ti-device-desktop ti-md text-danger me-2"></i>'
            };
            return (
              "<span class='text-truncate d-flex align-items-center text-heading'>" +
              roleBadgeObj[$role] != undefined ? roleBadgeObj[$role] + $role : $role +
              '</span>'
            );
          }
        },
        {
          // Plans
          targets: 1,
          render: function (data, type, full, meta) {
            var $display_name = full['display_name'];

            return '<span class="text-heading">' + $display_name + '</span>';
          }
        },
        {
          // User Status
          targets: 2,
          render: function (data, type, full, meta) {
            var $description = full['description'];

            return '<span class="text-heading">' + $description + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record"><i class="ti ti-trash ti-md"></i></a>' +
              '<button data-bs-target="#editRoleModal" data-bs-toggle="modal" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill edit-record"><i class="ti ti-pencil ti-md"></i></button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      dom:
        '<"row"' +
        '<"col-md-3"<l>>' +
        '<"col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0"fB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Search User',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      buttons: [
        
        {
          text: '<i class="ti ti-plus ti-xs me-md-2"></i><span class="d-md-inline-block d-none">Add new role</span>',
          className: 'btn btn-primary waves-effect waves-light rounded border-left-0 border-right-0',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addRoleModal'
          }
        }
      ],
    });
  }
  // Delete Record
  $('.datatables-users tbody').on('click', '.delete-record', function () {
    dtUser.row($(this).parents('tr')).remove().draw();
  });

  $('.datatables-users tbody').on('click', '.edit-record', function () {
    let index = dtUser.row($(this).parents('tr'))[0][0];
    let arayData = dtUser.row($(this).parents('tr')).context[0].aoData;
    let data = arayData[index]._aData;
    console.log(data);
    var role = {}
    $.ajax({
      url: '/app/get-role',
      type: 'GET',
      data: {
          id: data.id,
      },
      success: function(response) {
        role = response;
        console.log(role);
        $('#editRole').html(response);
      },
      error: function(response) {
          var jsonResponse = JSON.parse(response.responseText);
          var data = jsonResponse.data;
          alert(data);
      }
    });
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    // $('.dataTables_filter .form-control').removeClass('form-control-sm');
    // $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
