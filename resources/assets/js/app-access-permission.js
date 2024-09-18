/**
 * App user list (jquery)
 */

'use strict';

$(function () {
  var dataTablePermissions = $('.datatables-permissions'),
    dt_permission,
    userList = baseUrl + 'app/user/list';
  // Users List datatable
  if (dataTablePermissions.length) {
    dt_permission = dataTablePermissions.DataTable({
      ajax: '/app/fetch-permission', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: '' },
        { data: '' },
        { data: '' },
        { data: '' }
      ],
      columnDefs: [
        {
          // Name
          targets: 0,
          title: 'Permision Name',
          render: function (data, type, full, meta) {
            var $name = full['name'];
            return '<span class="text-nowrap text-heading">' + $name + '</span>';
          }
        },
        {
          // User Role
          targets: 1,
          title: 'Guard name',
          render: function (data, type, full, meta) {
            var $guard_name = full['guard_name']
            //   $output = '';
            // var roleBadgeObj = {
            //   Admin: '<a href="' + userList + '"><span class="badge me-4 bg-label-primary">Administrator</span></a>',
            //   Manager: '<a href="' + userList + '"><span class="badge me-4 bg-label-warning">Manager</span></a>',
            //   Users: '<a href="' + userList + '"><span class="badge me-4 bg-label-success">Users</span></a>',
            //   Support: '<a href="' + userList + '"><span class="badge me-4 bg-label-info">Support</span></a>',
            //   Restricted:
            //     '<a href="' + userList + '"><span class="badge me-4 bg-label-danger">Restricted User</span></a>'
            // };
            // for (var i = 0; i < $assignedTo.length; i++) {
            //   var val = $assignedTo[i];
            //   $output += roleBadgeObj[val];
            // }
            return '<span class="text-nowrap">' + $guard_name + '</span>';
          }
        },
        {
          // remove ordering from Name
          targets: 2,
          title: 'Created at',
          render: function (data, type, full, meta) {
            var $created_at = "2024-09-17";
            return '<span class="text-nowrap">' + $created_at + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record"><i class="ti ti-trash ti-md"></i></a>' +
              '<button data-bs-target="#editPermissionModal" data-bs-toggle="modal" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill edit-record"><i class="ti ti-pencil ti-md"></i></button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'asc']],
      dom:
        '<"row mx-1"' +
        '<"col-sm-12 col-md-3" l>' +
        '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap"<"me-4 mt-n6 mt-md-0"f>B>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Search Permissions',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Permission</span>',
          className: 'add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addPermissionModal'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
    });
  }

  // Delete Record
  $('.datatables-permissions tbody').on('click', '.delete-record', function () {
    let index = dt_permission.row($(this).parents('tr'))[0][0];
    let arayData = dt_permission.row($(this).parents('tr')).context[0].aoData;
    let data = arayData[index]._aData;
    $.ajax({
      url: '/app/delete-permission',
      type: 'GET',
      data: {
          id: data.id,
      },
      success: function(response) {
        alert(response.message)
      },
      error: function(response) {
          var jsonResponse = JSON.parse(response.responseText);
          var data = jsonResponse.data;
          alert(data);
      }
    })
    
    dt_permission.row($(this).parents('tr')).remove().draw();
  });

  $('.datatables-permissions tbody').on('click', '.edit-record', function () {
    let index = dt_permission.row($(this).parents('tr'))[0][0];
    console.log(index);
    let arayData = dt_permission.row($(this).parents('tr')).context[0].aoData;
    console.log(arayData);
    let data = arayData[index]._aData;
    console.log(data);
    $.ajax({
      url: '/app/get-permission',
      type: 'GET',
      data: {
          id: data.id,
      },
      success: function(response) {
        $('#bodyEditPermission').html(response);
        $('#editPermission').modal('show');
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
    // $('.dataTables_info').addClass('ms-n1');
    // $('.dataTables_paginate').addClass('me-n1');
  }, 300);
});
