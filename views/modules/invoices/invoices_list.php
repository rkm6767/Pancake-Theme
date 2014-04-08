
<style>


.condensed {
	margin:0 0 5px 0;
	padding:0;
	list-style:none;
}


.invoice-list-row div {
}


.invoice-list-row div.paid {
	background:#95d17b;
}


.invoice-list-row div h4 {
	color:#fff;
}

</style>


<ul class="condensed">
<?php foreach ($rows as $row): ?>
<?php $permission_module = isset($row->proposal_number) ? 'proposals' : 'invoices'; ?>

	
	
<li class="invoice-list-row">
	
	
	<div class="row paid">
		
		<div class="two columns">

		</div><!-- /two columns -->
		<div class="six columns">
			<h4>Invoice: <?php echo anchor('admin/invoices/edit/' . $row->unique_id, '#' . $row->invoice_number); ?> <span></span></h4>
		</div><!-- /six columns -->
		
		<div class="two columns">
			
		</div><!-- /two columns -->

		<div class="two columns">

		</div><!-- /two columns -->
	</div><!-- /invoice-banner row -->
	

</li>
































<?php endforeach ?>
</ul>
