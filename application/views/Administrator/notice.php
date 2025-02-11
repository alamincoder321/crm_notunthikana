<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select.open .dropdown-toggle {
		border-bottom: 1px solid #ccc;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#customers label {
		font-size: 13px;
	}

	#customers select {
		border-radius: 3px;
	}

	#customers .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#customers .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#customers input[type="file"] {
		display: none;
	}

	#customers .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#customers .custom-file-upload:hover {
		background-color: #41add6;
	}

	#customerImage {
		height: 100%;
	}
	.descText p {
		text-align: left;
	}

	.ck-editor__editable_inline {
		min-height: 300px;
	}
</style>
<div id="customers">
	<form @submit.prevent="saveCustomer">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-12">

				<div class="form-group clearfix">
					<label class="control-label col-md-12">Notice:</label>
					<div class="col-md-12">
						<textarea class="form-control" id="editor" name="editor"></textarea>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-12 text-right" style="margin-top: 5px;">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>

			</div>

		</div>
	</form>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="customers" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td class="descText" v-html="row.notice"></td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editCustomer(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteCustomer(row.id)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

<script>
	var editor;
	$(document).ready(function() {
		ClassicEditor.create(document.querySelector('#editor'))
			.then(newEditor => {
				editor = newEditor;
			});
	});
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#customers',
		data() {
			return {
				customer: {
					id: 0,
					notice: '',
				},
				customers: [],

				columns: [{
						label: 'Notice',
						field: 'notice',
						align: 'center'
					},
					{
						label: 'Action',
						align: 'center',
						filterable: false
					}
				],
				page: 1,
				per_page: 10,
				filter: ''
			}
		},
		filters: {
			dateOnly(datetime, format) {
				return moment(datetime).format(format);
			}
		},
		created() {
			this.getCustomers();
		},
		methods: {
			getCustomers() {
				axios.get('/get_notices').then(res => {
					this.customers = res.data;
				})
			},
			saveCustomer() {
				let url = '/add_notice';
				if (this.customer.id != 0) {
					url = '/update_notice';
				}
				this.customer.notice = editor.getData();
				let fd = new FormData();
				fd.append('data', JSON.stringify(this.customer));

				axios.post(url, fd).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.resetForm();
						this.getCustomers();
					}
				})
			},
			editCustomer(customer) {
				let keys = Object.keys(this.customer);
				keys.forEach(key => {
					this.customer[key] = customer[key];
				})
				
				this.customer.notice = editor.setData(customer.notice);
			},
			deleteCustomer(customerId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_notice', {
					id: customerId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getCustomers();
					}
				})
			},
			resetForm() {
				let keys = Object.keys(this.customer);
				keys.forEach(key => {
					if (typeof(this.customer[key]) == 'string') {
						this.customer[key] = '';
					} else if (typeof(this.customer[key]) == 'number') {
						this.customer[key] = 0;
					}
				})
				this.customer.notice = editor.setData("");
			}
		}
	})
</script>