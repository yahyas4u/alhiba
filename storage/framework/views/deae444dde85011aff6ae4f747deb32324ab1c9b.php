<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 0px 0;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media  print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page  { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; } 
        }
    </style>
  </head>
<body>

<div style="max-width:400px;margin:0 auto">
    <?php if(preg_match('~[0-9]~', url()->previous())): ?>
        <?php $url = '../../pos'; ?>
    <?php else: ?>
        <?php $url = url()->previous(); ?>
    <?php endif; ?>
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="<?php echo e($url); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Back')); ?></a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> <?php echo e(trans('file.Print')); ?></button></td>
            </tr>
        </table>
        <br>
    </div>
        
    <div id="receipt-data">
        <div class="centered">
          <?php if($general_setting->site_logo): ?>
                <img src="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" height="50" width="50" style="margin:0px 0px;">
            <?php endif; ?>
		  <h1><?php echo e($general_setting->site_title); ?></h1>
        		 <p>CR No: 
				 <br><?php echo e($lims_warehouse_data->address); ?>

			     <br>Tel : <?php echo e($lims_warehouse_data->phone); ?></p>
        </div>      
        <table>
            <tbody>
				  <tr>
                      <td><strong><?php echo e(trans('file.Date')); ?>:</strong></td>
					  <td><?php echo e($lims_sale_data->created_at); ?></td>
					  <td align="right"> <strong>:التاريخ</strong></td>
				  </tr>
				  <tr>
                      <td><strong>Invoice No:</strong></td>
					  <td><?php echo e($lims_sale_data->id); ?></td>
					  <td align="right"> <strong>:رقم</strong></td>
				  </tr>
				  <tr>
                      <td><strong><?php echo e(trans('file.customer')); ?>:</strong></td>
					  <td><?php echo e($lims_customer_data->name); ?></td>
					  <td align="right"> <strong>:عميل</strong></td>
				  </tr>
			</tbody>
		</table>
		<table>
				<tr style="text-align: left">
					<th style="width: 5%">#</td>
					<th style="width: 40%"><span>العنصر </span><br/>Item</th>
					<th style="width: 10%"><span>الكمية </span><br>Qty</th>
					<th style="width: 15%" align="center"><span>السعر </span><br>Rate</th>
					<th style="width: 15%" align="center"><span>خصم </span><br>Disc</th>
					<th style="width: 15%" align="center"><span>ضريبة </span><br>VAT</th>
					<th style="width: 20%" align="right"><span>اجمالي</span><br>Total</th>
				
		  </tr>
		<?php $total_product_tax = 0;?>
                <?php $__currentLoopData = $lims_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
				<tr style="text-align: left">
					<td style="width: 5%"><?php echo e($k+1); ?></td>
					<td style="width: 40%"><?php echo e($product_name); ?><br/><?php echo e($lims_product_data->namear); ?></td>
					<td style="width: 5%"><?php echo e($product_sale_data->qty); ?></td>
					<td style="width: 15%" align="center"><?php echo e(number_format((float)$product_sale_data->net_unit_price, 3, '.', '')); ?></td>
					<td style="width: 15%" align="center"><?php echo e(number_format((float)$product_sale_data->discount, 3, '.', '')); ?></td>
					<td style="width: 15%" align="center"><?php echo e(number_format((float)$product_sale_data->tax, 3, '.', '')); ?></td>
					<td style="width: 20%" align="right"><span><?php echo e(number_format((float)($product_sale_data->total), 3, '.', '')); ?></td>
				
				</tr>
		 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  </table>
                <?php $total_product_tax = 0;?>
                <?php $__currentLoopData = $lims_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody></table>
		<?php if($lims_sale_data->sale_type == 1): ?>
		<table>
			 <tbody>
				 <tr>
                      <th align="left"><?php echo e(trans('file.Total')); ?>:</th>
					  <th><?php echo e(number_format((float)$lims_sale_data->total_price, 3, '.', '')); ?></th>
					  <th align="right"> :اجمالي </th>
				  </tr>
				  <tr>
                      <th align="left">Total Discount:</th>
					  <th><?php echo e(number_format((float)$lims_sale_data->total_discount, 3, '.', '')); ?></th>
					  <th align="right">  :خصم</th>
				  </tr>
				  <tr>
				    <th align="left">Total VAT</th>
				    <th><?php echo e(number_format((float)$lims_sale_data->total_tax, 3, '.', '')); ?></th>
				    <th align="right">ضريبة</th>
		       </tr>
				  <tr>
                      <th align="left">Grand Total:</th>
					  <th><?php echo e(number_format((float)$lims_sale_data->grand_total, 3, '.', '')); ?></th>
					  <th align="right"> :اجمالي المبلغ </th>
				  </tr>
				 
				 <?php $__currentLoopData = $lims_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 <?php if($payment_data->paying_method == "Cash"): ?>
					  <tr>
						  <th align="left">Cash Recived:</th>
						  <th><?php echo e(number_format((float)$payment_data->amount+$payment_data->change, 3, '.', '')); ?></th>
						  <th align="right"> : المبلغ المستلم </th>
					  </tr>
					  <tr> 
						  <th align="left"> Change:</th>
						  <th><?php echo e(number_format((float)$payment_data->change, 3, '.', '')); ?></th>
						  <th align="right">  :المتبقي</th>					 
					  </tr>
				 		<?php else: ?>
				  		<tr> 
						  <th align="left"> Payment Type:</th>
						  <th>Card</th>
						  <th align="right">  :نوع الدفع</th>					 
					 	 </tr>
				 		<?php endif; ?>
				  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
	</table>
	<?php else: ?>
		<table>
			 <tbody>
				 <tr>
                      <th align="left"><?php echo e(trans('file.Total')); ?>:</th>
					  <th> OMR <?php echo e(number_format((float)$lims_sale_data->total_price, 3, '.', '')); ?></th>
					  <th align="right"> :اجمالي </th>
				  </tr>
				  <tr>
				    <th align="left">Total VAT</th>
				    <th><?php echo e(number_format((float)$lims_sale_data->total_tax, 3, '.', '')); ?></th>
				    <th align="right">ضريبة</th>
		       </tr>
				  <tr>
                      <th align="left">Grand Total:</th>
					  <th>OMR <?php echo e(number_format((float)$lims_sale_data->grand_total, 3, '.', '')); ?></th>
					  <th align="right"> :اجمالي المبلغ</th>
				  </tr>
				 <tr>
                      <th align="left">Advance Amount:</th>
					  <th>OMR <?php echo e(number_format((float)$lims_sale_data->advance_amount, 3, '.', '')); ?></th>
					  <th align="right">مبلغ المقدم</th>
				  </tr>
				 <tr>
                      <th align="left">Delivery Date:</th>
					  <th><?php echo e($lims_sale_data->delivery_date); ?></th>
					  <th align="right"> :تاريخ التسليم </th>
				  </tr>
				  <tr>
                      <th align="left">Balance Amount:</th>
					 <th><?php echo e(number_format((float)$lims_sale_data->grand_total-$lims_sale_data->advance_amount, 3, '.', '')); ?></th>
					  <th align="right">:بافي المبلغ </th>
				  </tr>
			</tbody>
	</table>
	<?php endif; ?>
        </table>
		<table>
            <tbody>
				<tr><td class="centered" colspan="3">شكر لحسن زيارتكم لنا</br><?php echo e(trans('file.Thank you for shopping with us')); ?></td></tr>
				<tr><td class="centered" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
			</tbody>
		</table>
    </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>
</body>
</html>
<?php /**PATH /var/www/html/alhiba/resources/views/sale/invoice.blade.php ENDPATH**/ ?>