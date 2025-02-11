<div id="propertyInvoice">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12" style="text-align: center;margin-bottom:10px;">
                        <h4 class="headingTitle">Property Information</h4>
                    </div>
                    <div class="col-xs-12 text-right" style="padding-right: 15px;">
                        <strong>Saved By: </strong> {{property.AddBy}}
                    </div>
                </div>
                <div class="row headerStyle">
                    <div class="col-xs-6">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:115px"><strong>Property Name</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Property_Name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:115px"><strong>Property Located</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Property_Address}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6 text-right">
                        <table style="width: 100%;">
                            <tr>
                                <td><strong>Property Type</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Type_Name}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Purpose</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Purpose_Name}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row headerStyle" style="margin-top: 15px;">
                    <div class="col-xs-12 text-center">
                        <h4 class="headingTitle">Property Details</h4>
                    </div>
                    <div class="col-xs-6" style="margin-top: 15px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:108px"><strong>Property Code</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Property_Code}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Apt. Owner/LO</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Apt_Owner}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Apt. No</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Apt_No}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Developer</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Developer}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Floor</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Floor_Name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Bed</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Bed}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Bath</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Bath}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Balcony</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Balcony}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Agreement Price</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Price}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6 text-right" style="margin-top: 15px;">
                        <table style="width: 100%;">
                            <tr>
                                <td><strong>MOU/Purchase</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.MOU}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Apt. Condition</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Apt_Condition}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Apt. Size</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Apt_Size}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Land Size</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Land_Size}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Unit Per Floor</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.unit_per_floor}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Facing</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.facing}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Parking</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.parking}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Gass Connection</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Gass_Connection}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Sft Rate After</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.per_sft_rate}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row headerStyle" style="margin-top: 15px;">
                    <div class="col-xs-12 text-center">
                        <h4 class="headingTitle">Contact Person</h4>
                    </div>
                    <div class="col-xs-6" style="margin-top: 15px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:108px"><strong>Employee</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Employee_Name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Person Name</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.contact_person_name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Person Email</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.contact_person_email}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:108px"><strong>Person Mobile</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.contact_person_mobile}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6 text-right" style="margin-top: 15px;">
                        <table style="width: 100%;">
                            <tr>
                                <td><strong>Save Date</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.AddTime | dateFormat('DD-MM-YYYY')}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Agreement Date</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.Agreement_Date | dateFormat('DD-MM-YYYY')}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Handover Date</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {{property.HandoverDate | dateFormat('DD-MM-YYYY')}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Property Status</strong></td>
                                <td><strong>:</strong></td>
                                <td style="text-transform:capitalize;">
                                    {{property.property_status}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#propertyInvoice',
        data() {
            return {
                property: {
                    Property_SlNo: "<?php echo $id; ?>"
                },
                style: null,
                companyProfile: null,
                currentBranch: null
            }
        },
        filters: {
            dateFormat(datetime, format) {
                return moment(datetime).format(format);
            }
        },
        created() {
            this.setStyle();
            this.getProperty();
            this.getCompanyProfile();
            this.getCurrentBranch();
        },
        methods: {
            getProperty() {
                axios.post('/get_property', {
                    propertyId: this.property.Property_SlNo
                }).then(res => {
                    this.property = res.data.properties[0];
                })
            },
            getCompanyProfile() {
                axios.get('/get_company_profile').then(res => {
                    this.companyProfile = res.data;
                })
            },
            getCurrentBranch() {
                axios.get('/get_current_branch').then(res => {
                    this.currentBranch = res.data;
                })
            },

            setStyle() {
                this.style = document.createElement('style');
                this.style.innerHTML = `                
                .headerStyle{
                    border: 2px solid gray;
                    border-radius: 10px;
                    padding: 8px 3px !important;
                    margin:0;
                }

                .headingTitle{
                    display: inline-block;
                    margin: 0px;
                    font-weight: 900;
                    padding: 3px 15px;
                    border: 2px solid gray;
                    text-align: center;
                    border-bottom-left-radius: 20px;
                    border-top-right-radius: 20px;
                }
            `;
                document.head.appendChild(this.style);
            },

            async print() {
                let invoiceContent =
                    document.querySelector("#invoiceContent").innerHTML;
                let printWindow = window.open(
                    "",
                    "PRINT",
                    `width=${screen.width}, height=${screen.height}, left=0, top=0`
                );

                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Billing Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }

                            @media print{
                                .totalColor{
                                    background-color: gainsboro !important;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="container">
                                            <div class="row" style="margin-bottom:10px;">
                                                <div class="col-xs-12"><img src="/assets/images/headerbg.jpg" alt="Logo" style="width:100%;border: 1px solid gray; border-radius: 5px;padding:5px;" /></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">${invoiceContent}</div>
                                            </div>
                                        </div> 
                                    </td>
                                </tr>
                            </tbody>                            
                        </table>
                        <div style="position:fixed;bottom:15px;left:0;width:100%;">
                            <div class="col-xs-12" style="margin-top: 70px;">
                                <table style="width:100%;margin: 0 auto;">
                                    <tr>
                                        <td style="text-align: center;width:200px;">
                                            <strong>Hunter</strong>
                                            <p style="margin: 0;margin-top:60px;border-top:1px solid black;font-weight:900;">Signature</p>
                                        </td>
                                        <td style="text-align: center;">
                                            <strong>H.O.T</strong>
                                            <p style="margin: 0 10px;margin-top:60px; border-top:1px solid black;font-weight:900;">Signature</p>
                                        </td>
                                        <td style="text-align: center;width:300px;">
                                            <strong>MANAGING DIRECTOR</strong>
                                            <p style="margin: 0;margin-top:60px;border-top:1px solid black;font-weight:900;">Signature</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </body>
                    </html>
				`);
                let invoiceStyle = printWindow.document.createElement("style");
                invoiceStyle.innerHTML = this.style.innerHTML;
                printWindow.document.head.appendChild(invoiceStyle);
                printWindow.moveTo(0, 0);

                printWindow.focus();
                await new Promise((resolve) => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            },

        }
    })
</script>