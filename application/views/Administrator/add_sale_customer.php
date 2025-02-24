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

	.table tr td {
		vertical-align: middle !important;
		text-align: left !important;
	}

	.form-control {
		margin-bottom: 0;
	}
</style>
<div id="customers">
	<form @submit.prevent="saveCustomer">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-sm table-bordered">
					<thead>
						<tr>
							<th style="padding: 15px 5px;" colspan="4">
								<h2 style="margin: 0;">Sale Lead Entry</h2>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width: 20%;">Lead ID:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.Customer_Code" readonly>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Client Name: <sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.Customer_Name" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Contact Number: <sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.Customer_Mobile" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 15%;text-align:left;">Zone: <sup class="text-danger">*</sup></td>
							<td style="width: 35%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="zones" style="margin: 0;" v-model="selectedZone" label="Zone_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/zone', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Area:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.Customer_Address" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;text-align:left;">Sft: <sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="sqfts" style="margin: 0;" v-model="selectedSqft" label="Sqft_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/sqft', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Bed & Bath:<sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.bedbath" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">S.Bed & S.Bath:<sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.sbedbath" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;text-align:left;">Budget: <sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="budgets" style="margin: 0;" v-model="selectedBudget" label="Budget_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/budget', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Floor:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.floor" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>

						<tr>
							<td style="width: 20%;text-align:left;">Property Status: <sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="statuss" style="margin: 0;" v-model="selectedStatus" label="Status_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/apt_status', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;text-align:left;">Apartment Condition:</td>
							<td style="width: 80%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="conditions" style="margin: 0;" v-model="selectedCondition" label="Condition_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/condition', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>

						<tr>
							<td style="width: 20%;">Pet Status:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.pet_status" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Apt. Face:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.apt_face" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>

						<tr>
							<td style="width: 20%;">Profession:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.profession" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Living At:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.living_at" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Others:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.others" placeholder="Typing..." autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="width: 20%;">Entry By:</td>
							<td style="width: 80%;">
								<input type="text" class="form-control" v-model="customer.AddBy" readonly>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;text-align:left;">Source:<sup class="text-danger">*</sup></td>
							<td style="width: 80%;">
								<div style="display: flex;align-items: center;justify-content: center;">
									<div style="width: 97%;">
										<v-select :options="sources" style="margin: 0;" v-model="selectedSource" label="Source_Name"></v-select>
									</div>
									<div style="width: 3%;">
										<button type="button" onclick="window.open('/source', '_blank')"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="width: 20%;"></td>
							<td style="width: 80%;">
								<button type="submit" class="btn btn-sm btn-success btn-block">{{customer.Customer_SlNo > 0 ? 'Update Client' : 'Save Client'}}</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
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
					Customer_SlNo: "<?= $customerId; ?>",
					Customer_Code: "<?php echo $Customer_Code; ?>",
					Customer_Name: '',
					Customer_Mobile: '',
					Customer_Address: '',
					bedbath: '',
					sbedbath: '',
					floor: '',
					pet_status: '',
					apt_face: '',
					profession: '',
					living_at: '',
					others: '',
					AddBy: "<?= $this->session->userdata('FullName'); ?>"
				},
				zones: [],
				selectedZone: null,
				sqfts: [],
				selectedSqft: null,
				budgets: [],
				selectedBudget: null,
				statuss: [],
				selectedStatus: null,
				conditions: [],
				selectedCondition: null,
				sources: [],
				selectedSource: null,
				userType: "<?php echo $this->session->userdata('accountType') ?>",
				userId: "<?php echo $this->session->userdata('userId') ?>",
			}
		},
		async created() {
			this.getZone();
			this.getSqft();
			this.getBudget();
			this.getStatus();
			this.getCondition();
			this.getSource();

			if (this.customer.Customer_SlNo != 0) {
				await this.getCustomers();
			}
		},
		methods: {
			getZone() {
				axios.get('/get_zone').then(res => {
					this.zones = res.data;
				})
			},
			getSqft() {
				axios.get('/get_sqft').then(res => {
					this.sqfts = res.data;
				})
			},
			getBudget() {
				axios.get('/get_budget').then(res => {
					this.budgets = res.data;
				})
			},
			getStatus() {
				axios.get('/get_apt_status').then(res => {
					this.statuss = res.data;
				})
			},
			getCondition() {
				axios.get('/get_condition').then(res => {
					this.conditions = res.data;
				})
			},
			getSource() {
				axios.get('/get_source').then(res => {
					this.sources = res.data;
				})
			},
			saveCustomer() {
				this.customer.zone_id = this.selectedZone != null ? this.selectedZone.Zone_SlNo : '';
				this.customer.sqft_id = this.selectedSqft != null ? this.selectedSqft.Sqft_SlNo : '';
				this.customer.budget_id = this.selectedBudget != null ? this.selectedBudget.Budget_SlNo : '';
				this.customer.status_id = this.selectedStatus != null ? this.selectedStatus.Status_SlNo : '';
				this.customer.source_id = this.selectedSource != null ? this.selectedSource.Source_SlNo : '';
				if (this.selectedCondition != null) {
					this.customer.condition_id = this.selectedCondition.Condition_SlNo;
				}

				let url = '/add_sale_customer';
				if (this.customer.Customer_SlNo != 0) {
					url = '/update_sale_customer';
				}

				let fd = new FormData();
				fd.append('data', JSON.stringify(this.customer));

				axios.post(url, fd).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						if (this.customer.Customer_SlNo != 0) {
							location.href = "/sale_customer";
						}
						this.resetForm();
						this.customer.Customer_Code = r.customerCode;
					}
				})
			},
			resetForm() {
				this.customer = {
					Customer_SlNo: 0,
					Customer_Code: "",
					Customer_Name: '',
					Customer_Mobile: '',
					Customer_Address: '',
					bedbath: '',
					sbedbath: '',
					floor: '',
					pet_status: '',
					apt_face: '',
					profession: '',
					living_at: '',
					others: '',
					AddBy: "<?= $this->session->userdata('FullName'); ?>"
				}
			},

			async getCustomers() {
				await axios.post("/get_sale_customers", {
					customerId: this.customer.Customer_SlNo
				}).then(res => {
					let customer = res.data[0];
					let keys = Object.keys(this.customer);
					keys.forEach(key => {
						this.customer[key] = customer[key];
					})

					setTimeout(() => {
						this.selectedZone = this.zones.find(item => item.Zone_SlNo == customer.zone_id);
						this.selectedSqft = this.sqfts.find(item => item.Sqft_SlNo == customer.sqft_id);
						this.selectedStatus = this.statuss.find(item => item.Status_SlNo == customer.status_id);
						this.selectedBudget = this.budgets.find(item => item.Budget_SlNo == customer.budget_id);
						this.selectedCondition = this.conditions.find(item => item.Condition_SlNo == customer.condition_id);
						this.selectedSource = this.sources.find(item => item.Source_SlNo == customer.source_id);
					}, 3000);
				})
			}
		}
	})
</script>