<template>
    <div class="container">
        <div class="col-md-12">
            <div class="rows">
                <div class="col-md-3 pull-right"  style="float:right;margin-top:20px">
                    <input v-model="filter" placeholder="Type to Search" class="form-control" ></input>
                </div>
            </div>
        <BTable striped hover :items="all_member" :filter="filter" :fields="fields" :per-page="perPage"
                :current-page="currentPage">
            <template slot="status" slot-scope="data">
                     <select class="form-control" >
                         <option :selected="data.value===1">Active</option>
                         <option :selected="data.value===2">Died</option>
                         <option :selected="data.value===3">Terminated</option>
                     </select>
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
                ],
                all_member:[]
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getMember()
        },
        methods: {
            getMember() {
                let vm=this
                axios.post(helper.get_member_api, {
                }).then(function (response) {
                    console.info(response)
                    vm.all_member=response.data.result
                    vm.totalRows=response.data.result.length
                }).catch(function (error) {
                    console.info(error)
                });

            },
        },

    }
</script>
