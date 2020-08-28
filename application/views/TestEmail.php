<style>
	.loading {
		display:none;
	}
	.btnSubmit:hover { 
		cursor:pointer; 
		color:blue;
	}
	.btnSubmit {
		border:1px solid #ccc;
		border-radius:10px;
		width:100px;
		text-align: center;
		font-size: 15px;
		line-height: 25px;
		vertical-align: middle;
	}
</style>
<script>
	$(document).ready(function(){

		$("#btnSubmit").click(function()
		{
			//e.preventDefault();
			if(confirm("Kirim Email ?"))
			{
				$(".loading").show();
				var csrf_bit=$("input[name=csrf_bit]").val();
				$.post('<?php echo site_url('Test/TestEmail'); ?>',
					{
						'EmailAddress'  :$("#EmailAdd").val(),
						'csrf_bit'  	:csrf_bit
					},
					function(data)
					{
						alert(data);
						$(".loading").hide();
					},
					'json', errorAjax
				);
			}
		});
	});
</script>

<?php echo form_open(); ?>
<div style="float:left;">
	<label for="BranchID">Alamat Email</label>
	<label><?php  
		$attr = array 
		(
			'placeholder' => 'Alamat Email',
			'id' => 'EmailAdd',
			'maxlength' => '100'
		);
		echo BuildInput('text','EmailAdd',$attr);
	?></label>
</div>
<div style="float:left;">
	<div class="btnSubmit" id="btnSubmit">Email</div>
</div>

<?php echo form_close(); ?>
