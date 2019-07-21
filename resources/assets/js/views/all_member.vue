<template>
    <div class="container">
        <div class="col-md-12">
            <div class="rows">
                <div class="col-md-3 pull-right"  style="float:right;margin-top:20px">
                    <input v-model="filter" placeholder="Type to Search" class="form-control" ></input>
                </div>
            </div>
        <BTable striped hover :items="all_member" :filter="filter" :fields="fields" :per-page="perPage"
                :current-page="currentPage"  @filtered="onFiltered">
            <template slot="name" slot-scope="data">
                <router-link tag="a" class="nav-link" :to="{ name: 'member', params: { memberId: data.item.id }}">
                    {{data.value}}
                </router-link>
            </template>

            <template slot="status" slot-scope="data">
                     <select class="form-control" >
                         <option :selected="data.value===1">Active</option>
                         <option :selected="data.value===2">Died</option>
                         <option :selected="data.value===3">Terminated</option>
                     </select>
            </template>
            <template slot="id" slot-scope="data">
                <router-link tag="a" class="nav-link" :to="{ name: 'edit_member', params: { memberId: data.value }}">
                    Edit Member
                </router-link>
            </template>

            <template slot="payment_status" slot-scope="data">
                <span  v-if="data.value==0"><a href="javascript:void(0)" @click="updatePaymentStatus(data.item.id,data.value)">{{payment_status}}</a></span>
                <span v-else>Paid</span>

            </template>
        </BTable>
            <BPagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
            ></BPagination>
        </div>
    </div>

</template>

<script>
    import BTable from 'bootstrap-vue/es/components/table/table'
    import BPagination from 'bootstrap-vue/es/components/pagination/pagination'
    import helper from "../helper/consts"
    export default {
        data() {
            components: {
                    BTable
                   BPagination
            }
            return{
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [5, 10, 15],
                filter: null,
                payment_status:'Unpaid',
                fields: [
                     {
                        key: 'name',
                        label: 'Name',
                        sortable: true,
                     },
                     {
                        key: 'address',
                        label: 'Address',
                        sortable: true,
                    },
                    {
                        key: 'postcode',
                        label: 'Postcode',
                        sortable: true,
                    },
                    {
                        key: 'telephone',
                        label: 'Telephone',
                        sortable: true,
                    },
                    {
                        key: 'status',
                        label: 'Status',
                        sortable: false,
                    },
                    {
                        key: 'id',
                        label: 'Edit',
                        sortable: false,
                    },
                    {
                        key: 'payment_status',
                        label: 'Payment Status',
                        sortable: false,
                    },

                ],
                all_member:[]
            }
        },
        mounted() {
            this.getMember()
        },
        methods: {
            getMember() {
                let vm=this
                axios.post(helper.get_member_api, {
                }).then(function (response) {
                    vm.all_member=response.data.result
                    vm.totalRows=response.data.result.length
                }).catch(function (error) {
                    console.info(error)
                });

            },
            updatePaymentStatus(id,payment_status){
                let vm=this
                axios.post(helper.update_payment_status_api, {
                    id: id,
                    payment_status: payment_status
                }).then(response =>response.data).then(response => {
                    this.getMember()
                }).catch(error=>error.data).then(error => {
                    vm.errors=error.response.data.msg
                });
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        },

    }
</script>
