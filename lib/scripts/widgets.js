// $(document).ready(function() {
//     $('.table-responsive').on('show.bs.dropdown', function () {
//         $('.table-responsive').css( "overflow", "inherit" );
//     });

//     $('.table-responsive').on('hide.bs.dropdown', function () {
//         $('.table-responsive').css( "overflow", "auto" );
//     });

//     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
//       checkboxClass: 'icheckbox_minimal-blue',
//       radioClass   : 'iradio_minimal-blue'
//     });

//   $('.repBox').boxWidget({
//     	animationSpeed: 500,
//     	collapseTrigger: '.btnCollapse',
//     	// removeTrigger: '#my-remove-button-trigger',
//     	collapseIcon: 'fa-minus',
//     	expandIcon: 'fa-plus',
//     	removeIcon: 'fa-times'
//   });

// $(".datepicker").datepicker({
//     changeMonth: true, 
//     changeYear: true, 
//     dateFormat: "dd/mm/yy",
//     yearRange: "-90:+00",
//     // endDate: new Date()
//   });

// $(".datepickerfuture").datepicker({
//     changeMonth: true, 
//     changeYear: true, 
//     dateFormat: "dd/mm/yy",
//     startDate : new Date()
//   });

// $(".datebday").datepicker({
//     changeMonth: true, 
//     changeYear: true, 
//     dateFormat: "dd/mm/yy",
//     yearRange: "-90:+00",
//     endDate: new Date()
//   });

// $(".timepicker").timepicker();
// // $(".timepicker")..val('');

//   $(".month-year-picker").datepicker({
//       format : "mm/yyyy",
//       viewMode : 1,
//       minViewMode : 1,
//       endDate: new Date()

//   });



// $(".autoNumeric").autoNumeric();
//   $("form select, form input").on('change', function() {
//       $(this).closest("div.repBox").removeClass("box-success");
//       $(this).closest("div.repBox").addClass("box-warning");
      
//       $(this).closest("div").removeClass("has-error");
//   });

//     $("form input, form textarea").on('keyup', function() {
//       $(this).closest("div.repBox").removeClass("box-success");
//       $(this).closest("div.repBox").addClass("box-warning");
      
//       $(this).closest("div").removeClass("has-error");
//     });


//     $(".numOnly").keypress(function (e) {
//      //if the letter is not digit then display error and don't type anything
//         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//         //display error message
//             return false;
//         }
//    });

    

    
// });



$(document).ready(function() {

 
    _execWidgets();

});

function _execWidgets() {
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    });

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
    

    $('.repBox').boxWidget({
        animationSpeed: 500,
        collapseTrigger: '.btnCollapse',
        // removeTrigger: '#my-remove-button-trigger',
        collapseIcon: 'fa-minus',
        expandIcon: 'fa-plus',
        removeIcon: 'fa-times'
    });

    $(".datepicker").datepicker({
        changeMonth: true, 
        changeYear: true, 
        dateFormat: "dd/mm/yy",
        yearRange: "-90:+00",
        // endDate: new Date()
      });

    $(".datebday").datepicker({
        changeMonth: true, 
        changeYear: true, 
        dateFormat: "dd/mm/yy",
        yearRange: "-90:+00",
        endDate: new Date()
      });

    $(".timepicker").timepicker();
    // $(".timepicker")..val('');

      $(".month-year-picker").datepicker({
          format : "mm/yyyy",
          viewMode : 1,
          minViewMode : 1,
          endDate: new Date()

      });

    $(".dateyearpicker").datepicker({
          format : "yyyy",
          viewMode : 'years',
          minViewMode : 'years',
          endDate: new Date()

      });  

    $(".datepickerfuture").datepicker({
    changeMonth: true, 
    changeYear: true, 
    dateFormat: "dd/mm/yy",
    startDate : new Date()
  });

      $(".month-year-picker, .datepicker, .timepicker, .datepickerfuture").on('keypress', function()
      {
        return false;  
      });
      

    $(".autoNumeric").autoNumeric();
      $("form select, form input").on('change', function() {
          $(this).closest("div.repBox").removeClass("box-success");
          $(this).closest("div.repBox").addClass("box-warning");
          
          $(this).closest("div").removeClass("has-error");
      });

    $("form input, form textarea").on('keyup', function() {
        $(this).closest("div.repBox").removeClass("box-success");
        $(this).closest("div.repBox").addClass("box-warning");
      
        $(this).closest("div").removeClass("has-error");
    });


    $(".numOnly").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
            return false;
        }
    });


    $(".tab-content select, .tab-content input").on('change', function() {
        var sParent   = $(this).closest("div.tab-pane").attr('id');
        
        $("a[aria-controls="+sParent+"] .fa-circle").fadeIn();

    });

    $(".tab-content select, .tab-content input").on('keyup', function() {
        var sParent   = $(this).closest("div.tab-pane").attr('id');
        
        $("a[aria-controls="+sParent+"] .fa-circle").fadeIn();
    });

    $('.select2').select2();

}

