<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Source  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="source_name" name="source_name" placeholder="Source" value="<?php echo $selected->source_name; ?>" class="col-xs-10 col-sm-4" />
				<input name="id" id="id" type="hidden" value="<?php echo $selected->id; ?>"/>
				<span id="msg"></span>
				<?php echo form_error('source_name'); ?>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-info" onclick="submit()" name="btnSubmit">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
		</div>
		
</div>
</div>
</div>


			
<div class="row">
	<div class="col-xs-12">

		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Source Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<div id="saveResult">
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</th>
						<th>SL No</th>
						<th>Source</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$BRANCHid=$this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM tbl_source where status='a' order by source_name asc");
					$row = $query->result();
					//echo "<pre>";print_r($row);exit;
					 ?>
					<?php $i=1; foreach($row as $row){ ?>
					<tr>
						<td class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td><?php echo $i++; ?></td>
						<td><a href="#"><?php echo $row->source_name; ?></a></td>
						<td>
						<div class="hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="ace-icon fa fa-search-plus bigger-130"></i>
								</a>

								<a class="green" href="<?php echo base_url() ?>sourceedit/<?php echo $row->id; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleted(<?php echo $row->id; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
							</div>
						</td>
					</tr>
					
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
    function submit(){
        var id= $("#id").val();
        var district= $("#source_name").val();
        if(district==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var catname=encodeURIComponent(catname);
        var inputdata = 'source_name='+district+'&id='+id;
        var urldata = "<?php echo base_url();?>sourceupdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){   
			if(data=="false"){
				 alert("This source allready exists");
            }else{
				alert("Update Success");
				window.location = '/source';
			}
            }
        });
    }
</script>

<script type="text/javascript">
    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
        var confirmation = confirm("are you sure you want to delete this ?");
        var urldata = "<?php echo base_url() ?>sourcedelete";
		if(confirmation){
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                //$("#saveResult").html(data);
                alert("Delete Success");
                window.location.href='<?php echo base_url(); ?>Administrator/page/source';
            }
        });
		};
    }
</script>
		
