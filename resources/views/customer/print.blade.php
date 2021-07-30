@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section class="forms">
    <div id="print-barcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	    <div role="document" class="modal-dialog">
	        <div class="modal-content">
		        <div class="modal-header">
		          <h5 id="modal_header" class="modal-title">{{trans('file.Barcode')}}</h5>&nbsp;&nbsp;
		          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
		          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		        </div>
		        <div class="modal-body">
	        		<div id="label-content">
	        		</div>
		        </div>
	        </div>
	    </div>
    </div>
</section>

<script type="text/javascript">
	//Delete product
	$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
	    rowindex = $(this).closest('tr').index();
	    $(this).closest("tr").remove();
	});

	$("#submit-button").on("click", function(event){
		$('#label-content').html(htmltext);
		$('#print-barcode').modal('show');
	});

	$("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('print-barcode');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #modal_header { display: none } #print-btn { display: none } #close-btn { display: none } } table.barcodelist { page-break-inside:auto } table.barcodelist tr { height:25px; width: 38px; page-break-inside:avoid; page-break-after:auto }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

</script>
@endsection