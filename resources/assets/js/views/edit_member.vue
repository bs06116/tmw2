<template>
    <div class="container">

        <div class="col-md-12">
            <form class="form-horizontal" id="product_form" role="form">
                <div class="form-group">
                    <label class="label">Book Number</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="book_number" placeholder="Book Number"
                               v-model="book_number">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="form-control" type="text" name="name" placeholder="Name" v-model="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="form-control" type="email" name="email" placeholder="Email"
                               v-model="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Relation</label>
                    <select class="form-control" id="head_relation" v-model="head_relation">
                        <option value="">Selection Relation</option>
                        <option value="husband">Husband</option>
                        <option value="wife">Wife</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label">Address</label>
                    <div class="form-group">
                        <textarea class="form-control" name="address" placeholder="Address"
                                  v-model="address"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">PostCode</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="postalcode" v-model="postcode"
                               placeholder="PostCode">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Telephone</label>
                    <div class="form-group">
                        <input class="form-control" type="tel" id="tel" v-model="telephone" placeholder="Telephone">
                    </div>
                </div>

                <!--<my-component v-model="fname" :value="fname" v-for="n in hellocount" :key="n"></my-component>-->
                <div v-for="(dl,index) in data_list">
                    <hr>
                    <div class="form-group">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="form-control" type="text" v-model="fname[index]"   placeholder="Name">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">DOB</label>
                        <div class="control">
                            <input class="form-control" type="text" v-model="dob[index]" placeholder="DOB">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label">Gender</label>
                        <div class="control">
                            <select class="form-control" type="text" v-model="gender[index]" id="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label">Relation</label>
                        <div class="control">
                            <select class="form-control" id="relation" v-model="relation[index]">
                                <option value="">Select Relation</option>
                                <option value="husband">Husband</option>
                                <option value="wife">Wife</option>
                                <option value="son">Son</option>
                                <option value="daughter">Daughter</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>
                <div class="alert alert-danger fade show" role="alert" v-if="errors">
                    <span v-for="e in errors"><p v-html="e"></p></span>
                </div>
                <div class="alert alert-success alert-dismissible" v-if="message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong>
                    <span v-html="message"></span>
                </div>
                <div class="field is-grouped">
                    <div class="form-group col-md-3">
                        <button type="button" class="btn btn-primary btn-block" @click="insertRow()" id="add_more">Add
                            More
                        </button>
                    </div>
                    <div class="form-group col-md-3">
                        <button id="add_product" type="button" class="btn btn-primary" @click.prevent="updateMember()"
                                style="background-color: #2ab27b !important;">Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>
<style>
    .cross_btn {
        position: absolute;
        top: 0;
        float: right;
        right: 0;
    }
</style>

<script>
    import helper from "../helper/consts"

    export default {
        data() {
            // Vue.component('my-component', {
            //     props: ['fname'],
            //     template: '<div><hr><div class="form-group">' +
            //     '<label class="label">Name</label>' +
            //     '<div class="control">' +
            //     '<input class="form-control" type="text" v-model="fname" name="fname"  placeholder="Name">' +
            //     '</div></div>' +
            //     '<div class="field">' +
            //     '<label class="label">DOB</label>' +
            //     '<div class="control">' +
            //     '<input class="form-control" type="text" v-model="dob" id="dob" placeholder="dob">' +
            //     '</div></div>' +
            //     '<div class="form-group">' +
            //     '<label class="label">Gender</label>' +
            //     '<div class="control">' +
            //     '<select class="form-control" type="text" v-model="gender" id="gender">' +
            //     '<option value="male">Male</option>' +
            //     '<option value="female">Female</option>' +
            //     '</select>' +
            //     '</div></div>' +
            //     '<div class="form-group">' +
            //     '<label class="label">Relation</label>' +
            //     '<div class="control">' +
            //     '<select class="form-control" id="relation" v-model="relation">' +
            //     '<option value="husband">Husband</option>' +
            //     '<option value="wife">Wife</option>' +
            //     '<option value="son">Son</option>' +
            //     '<option value="daughter">Daughter</option>' +
            //     '</select>' +
            //     '</div>' +
            //     '</div></div>',
            //     data() {
            //
            //     }
            //
            // })
            return {
                book_number: "",
                name: "",
                email: "",
                head_relation: "",
                address: "",
                postcode: "",
                telephone: "",
                hellocount: 0,
                fname: [],
                dob:[],
                gender:[],
                relation:[],
                member_relation:[],
                data_list:[],
                errors: "",
                message:""
            }
        },
        mounted() {
            this.getMember()
        },
        methods: {
            updateMember() {
                const vm = this
                axios.post(helper.update_member_api, {
                    user_id:this.id,
                    book_number: this.book_number,
                    name: this.name,
                    email: this.email,
                    head_relation: this.head_relation,
                    address: this.address,
                    postcode: this.postcode,
                    telephone: this.telephone,
                    fname: this.fname,
                    dob:this.dob,
                    gender:this.gender,
                    relation:this.relation
                }).then(response => response.data).then(response => {
                    this.errors=false
                    this.message=response.message
                }).catch(function (error) {
                    $(".alert").show()
                    vm.errors = error.response.data.errors
                });
            },
            getMember() {
                this.id=this.$route.params.memberId;
                const vm = this
                axios.post(helper.single_member_api, {
                    id:this.$route.params.memberId
                }).then(response => response.data).then(response => {
                    this.book_number=response.member_relation.book_number
                    this.name=response.member_relation.name
                    this.address=response.member_relation.address
                    this.email=response.member_relation.email
                    this.head_relation=response.member_relation.relation
                    this.postcode=response.member_relation.postcode
                    this.telephone=response.member_relation.telephone
                    this.data_list=response.user_relation
                    Object.keys(this.data_list).forEach(key => {
                        this.fname.push(this.data_list[key].name)
                        this.dob.push(this.data_list[key].dob)
                        this.gender.push(this.data_list[key].gender)
                        this.relation.push(this.data_list[key].relation)
                    })

                }).catch(function (error) {
                    vm.errors = error.response.data.errors
                });
            },
            insertRow(){
                this.data_list.push(
                    {
                        fname:"",
                        dob:""
                    }
                );
            }
        },


    }
</script>
