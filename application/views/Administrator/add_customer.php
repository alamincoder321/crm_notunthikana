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
</style>
<div id="customers">
	<form @submit.prevent="saveCustomer" style="display: none;" :style="{display: userType != 'u' ? '' : 'none'}" v-if="userType != 'u'">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-5">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Client Type:</label>
					<div class="col-md-7">
						<label for="sale">
							<input type="radio" id="sale" value="sale" v-model="customer.Customer_Type" /> Sale
						</label>
						<label for="rent">
							<input type="radio" id="rent" value="rent" v-model="customer.Customer_Type" /> Rent
						</label>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Client Id:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="customer.Customer_Code" required readonly>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Property Id:</label>
					<div class="col-md-7">
						<v-select v-bind:options="properties" v-model="selectedProperty" label="display_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/property" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Client Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="customer.Customer_Name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Address:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="customer.Customer_Address">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Stage:</label>
					<div class="col-md-7">
						<v-select v-bind:options="types" v-model="selectedType" label="type_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/type" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>



				<div class="form-group clearfix">
					<label class="control-label col-md-4">Source:</label>
					<div class="col-md-7">
						<v-select v-bind:options="sources" v-model="selectedSource" label="source_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/source" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>
			</div>

			<div class="col-md-5">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Mobile:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="customer.Customer_Mobile" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Email:</label>
					<div class="col-md-7">
						<input type="email" class="form-control" v-model="customer.Customer_Email">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Area:</label>
					<div class="col-md-7">
						<select class="form-control" v-if="districts.length == 0"></select>
						<v-select v-bind:options="districts" v-model="selectedDistrict" label="District_Name" v-if="districts.length > 0"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/area" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Employee:</label>
					<div class="col-md-7">
						<v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/employee" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">User:</label>
					<div class="col-md-7">
						<v-select v-bind:options="users" v-model="selectedUser" label="User_Name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/user" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4 text-right">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>
			</div>
			<div class="col-md-2 text-center;">
				<div class="form-group clearfix">
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="customerImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="customerImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
					</div>
					<div style="text-align:center;">
						<label class="custom-file-upload">
							<input type="file" @change="previewImage" />
							Select Image
						</label>
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
							<td>{{row.sl}}</td>
							<td>
								<img :src="row.customerImage" style="width: 40px; height: 40px; border: 1px solid #a5a5a5; border-radius: 5px;" />
							</td>
							<td>{{ row.Customer_Code }}</td>
							<td>{{ row.AddTime | dateOnly("DD-MM-YYYY") }}</td>
							<td>{{ row.Customer_Name }}</td>
							<td>{{ row.Customer_Type }}</td>
							<td>{{ row.Property_Name }}</td>
							<td>{{ row.Customer_Mobile }}</td>
							<td>{{ row.Customer_Email }}</td>
							<td>{{ row.Customer_Address }}</td>
							<td>{{ row.District_Name }}</td>
							<td>{{ row.type_name }}</td>
							<td>{{ row.source_name }}</td>
							<td>{{ row.Employee_Name }}</td>
							<td>{{ row.customer_status }}</td>
							<td>{{ row.AddBy }}</td>
							<td>{{ row.User_Name }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="showModal(row)" style="background: #ff9600; border: none; padding: 5px 10px; color: white; border-radius: 5px;">
										Assign
									</button>
									<button type="button" class="button edit" @click="editCustomer(row)">
										<i class="fa fa-pencil"></i>
									</button>
								<?php } ?>
								<?php if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a') { ?>
									<button type="button" class="button" @click="deleteCustomer(row.Customer_SlNo)">
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


	<!-- modal here -->
	<div class="modal myModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
					<h5 class="modal-title" style="width:90%;margin: 0;">Client Assign on User</h5>
					<button type="button" style="width: 10%; margin: 0px; display: flex; align-items: center; justify-content: end;" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="margin: 0;font-size: 20px;">X</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="user">User:</label>
						<v-select :options="users" v-model="selectedUser" label="User_Name"></v-select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" @click="assignClient" class="btn btn-primary">Assign Client</button>
				</div>
			</div>
		</div>
	</div>

	<!-- access modal here -->
	<div class="modal accessModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
					<h5 class="modal-title" style="width:95%;margin: 0;">Management permission needed...</h5>
					<button type="button" style="width: 5%; margin: 0px; display: flex; align-items: center; justify-content: end;" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="margin: 0;font-size: 20px;">X</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="password" class="form-control" v-model="otp" placeholder="otp">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" @click="editAccess" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#customers',
		data() {
			return {
				customer: {
					Customer_SlNo: 0,
					Customer_Code: "<?php echo $Customer_Code; ?>",
					Customer_Name: '',
					Customer_Type: 'sale',
					customer_status: 'Active',
					Customer_Mobile: '',
					Customer_Email: '',
					Customer_Address: '',
					area_ID: '',
					propertyId: '',
					employeeId: '',
				},
				customers: [],
				districts: [],
				selectedDistrict: null,
				sources: [],
				selectedSource: null,
				types: [],
				selectedType: null,
				properties: [],
				selectedProperty: null,
				imageUrl: '',
				selectedFile: null,
				users: [],
				selectedUser: null,
				employees: [],
				selectedEmployee: null,
				edit_process: false,
				userType: "<?php echo $this->session->userdata('accountType') ?>",
				userId: "<?php echo $this->session->userdata('userId') ?>",
				columns: [{
						label: 'Sl',
						field: 'sl'
					},
					{
						label: 'Image',
						field: 'customerImage',
						align: 'center'
					},
					{
						label: 'Client Id',
						field: 'Customer_Code',
						align: 'center',
						filterable: false
					},
					{
						label: 'Client_Entry_Date',
						field: 'AddTime',
						align: 'center'
					},
					{
						label: 'Client_Name',
						field: 'Customer_Name',
						align: 'center'
					},
					{
						label: 'Client Type',
						field: 'Customer_Type',
						align: 'center'
					},
					{
						label: 'Property',
						field: 'Property_Name',
						align: 'center'
					},
					{
						label: 'Mobile',
						field: 'Customer_Mobile',
						align: 'center'
					},
					{
						label: 'Email',
						field: 'Customer_Email',
						align: 'center'
					},
					{
						label: 'Address',
						field: 'Customer_Address',
						align: 'center'
					},
					{
						label: 'Area',
						field: 'District_Name',
						align: 'center'
					},
					{
						label: 'Stage',
						field: 'type_name',
						align: 'center'
					},
					{
						label: 'Source',
						field: 'source_name',
						align: 'center'
					},
					{
						label: 'Employee',
						field: 'Employee_Name',
						align: 'center'
					},
					{
						label: 'Status',
						field: 'customer_status',
						align: 'center'
					},
					{
						label: 'Entry_By',
						field: 'AddBy',
						align: 'center'
					},
					{
						label: 'AssignBy',
						field: 'User_Name',
						align: 'center'
					},
					{
						label: 'Action',
						align: 'center',
						filterable: false
					}
				],
				page: 1,
				per_page: 100,
				filter: '',

				clientRow: {},
				otp: '',
				editaccess: false,
				customerInfo: {}
			}
		},
		filters: {
			dateOnly(datetime, format) {
				return moment(datetime).format(format);
			}
		},
		created() {
			this.getDistricts();
			this.getTypes();
			this.getSources();
			this.getProperty();
			this.getUsers();
			this.getEmployees();
			this.getCustomers();
		},
		methods: {
			getDistricts() {
				axios.get('/get_districts').then(res => {
					this.districts = res.data;
				})
			},
			getUsers() {
				axios.get('/get_users').then(res => {
					if (this.userType == 'm' || this.userType == 'a') {
						this.users = res.data.filter(item => item.User_SlNo != 1);
					} else if (this.userType == 'e') {
						this.users = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
					}
				})
			},
			getEmployees() {
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getProperty() {
				axios.get('/get_property').then(res => {
					this.properties = res.data.properties.map(item => {
						item.display_name = `${item.Property_Name} - ${item.Property_Code}`;
						return item;
					});
				})
			},
			getSources() {
				axios.get('/get_sources').then(res => {
					this.sources = res.data;
				})
			},
			getTypes() {
				axios.get('/get_types').then(res => {
					this.types = res.data;
				})
			},
			getCustomers() {
				let filter = {};
				if (this.userType != 'm') {
					filter.user_id = this.userId;
				}
				axios.post('/get_customers', filter).then(res => {
					this.customers = res.data.map((item, index) => {
						item.sl = index + 1;
						item.customerImage = item.image_name ? `/${item.image_name}` : '/uploads/nouserImage.jpg';
						return item;
					});
				})
			},
			previewImage(event) {
				const WIDTH = 200;
				const HEIGHT = 200;
				if (event.target.files[0]) {
					let reader = new FileReader();
					reader.readAsDataURL(event.target.files[0]);
					reader.onload = (ev) => {
						let img = new Image();
						img.src = ev.target.result;
						img.onload = async e => {
							let canvas = document.createElement('canvas');
							canvas.width = WIDTH;
							canvas.height = HEIGHT;
							const context = canvas.getContext("2d");
							context.drawImage(img, 0, 0, canvas.width, canvas.height);
							let new_img_url = context.canvas.toDataURL(event.target.files[0].type);
							this.imageUrl = new_img_url;
							const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1))
							this.selectedFile = new File([resizedImage], event.target.files[0].name, {
								type: resizedImage.type
							});
						}
					}
				} else {
					event.target.value = '';
				}
			},
			saveCustomer() {
				if (this.selectedType == null) {
					alert('Select Stage');
					return;
				}

				if (this.selectedSource == null) {
					alert('Select source');
					return;
				}

				if (this.selectedDistrict == null) {
					alert('Select area');
					return;
				}

				this.customer.area_ID = this.selectedDistrict.District_SlNo;
				this.customer.source_id = this.selectedSource.id;
				this.customer.type_id = this.selectedType.id;
				this.customer.user_id = this.selectedUser != null ? this.selectedUser.User_SlNo : '';
				this.customer.propertyId = this.selectedProperty != null ? this.selectedProperty.Property_SlNo : "";
				this.customer.employeeId = this.selectedEmployee != null ? this.selectedEmployee.Employee_SlNo : "";

				let url = '/add_customer';
				if (this.customer.Customer_SlNo != 0) {
					url = '/update_customer';
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.customer));

				axios.post(url, fd).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.resetForm();
						this.customer.Customer_Code = r.customerCode;
						this.editaccess = false;
						this.getCustomers();
					}
				})
			},
			async editCustomer(customer) {
				this.customerInfo = customer;
				if (this.editaccess == false) {
					$(".accessModal").modal('show');
					return;
				}

				this.edit_process = true;
				let keys = Object.keys(this.customer);
				keys.forEach(key => {
					this.customer[key] = customer[key];
				})

				this.selectedDistrict = {
					District_SlNo: customer.area_ID,
					District_Name: customer.District_Name
				}

				this.selectedSource = {
					id: customer.source_id,
					source_name: customer.source_name
				}
				this.selectedUser = {
					User_SlNo: customer.user_id,
					User_Name: customer.User_Name
				}

				this.selectedType = {
					id: customer.type_id,
					type_name: customer.type_name
				}
				this.selectedEmployee = {
					Employee_SlNo: customer.employeeId,
					Employee_Name: customer.Employee_Name
				}
				this.selectedProperty = {
					Property_SlNo: customer.propertyId,
					display_name: `${customer.Property_Name} - ${customer.Customer_Code}`
				}

				if (customer.image_name == null || customer.image_name == '') {
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/customers/' + customer.image_name;
				}

				setTimeout(() => {
					this.edit_process = false;
				}, 500)
			},
			deleteCustomer(customerId) {
				this.customerInfo = customerId;
				if (this.editaccess == false) {
					$(".accessModal").modal('show');
					return;
				}

				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					this.editaccess = false;
					return;
				}
				axios.post('/delete_customer', {
					customerId: customerId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.editaccess = false;
						this.getCustomers();
					}
				})
			},
			resetForm() {
				let keys = Object.keys(this.customer);
				keys = keys.filter(key => key != "Customer_Type");
				keys.forEach(key => {
					if (typeof(this.customer[key]) == 'string') {
						this.customer[key] = '';
					} else if (typeof(this.customer[key]) == 'number') {
						this.customer[key] = 0;
					}
				})
				this.customer.customer_status = 'Active';
				this.imageUrl = '';
				this.selectedFile = null;
			},

			showModal(row) {
				this.clientRow = row;
				this.selectedUser = {
					User_SlNo: row.user_id,
					User_Name: row.User_Name
				}
				$(".myModal").modal("show");
			},
			assignClient() {
				let filter = {
					Customer_SlNo: this.clientRow.Customer_SlNo,
					user_id: this.selectedUser.User_SlNo
				}

				axios.post('/assign_customer', filter)
					.then(res => {
						alert(res.data.message);
						this.getCustomers();
						$(".myModal").modal("hide");
					})
			},

			editAccess() {
				axios.post('/check_otp', {
					otp: this.otp
				}).then(res => {
					this.editaccess = res.data.status;
					if (this.editaccess) {
						$(".accessModal").modal('hide');
						this.otp = "";
						if (typeof(this.customerInfo) == 'object') {
							this.editCustomer(this.customerInfo);
						} else {
							this.deleteCustomer(this.customerInfo);
						}
					} else {
						alert(res.data.message);
					}
				})
			}
		}
	})
</script>