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
                            <input class="form-control" type="text" v-model="fname[index]" name="fname" placeholder="Name">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">DOB</label>
                        <div class="control">
                            <input class="form-control" type="text" v-model="dob[index]" id="dob" placeholder="DOB">
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
                    <button type="button" class="close cross_btn" id="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="field is-grouped">

                    <div class="form-group col-md-3">
                        <button type="button" class="btn btn-primary btn-block" @click="insertRow()" id="add_more">Add
                            More
                        </button>
                    </div>
                    <div class="form-group col-md-3">
                        <button id="add_product" type="button" class="btn btn-primary" @click.prevent="addMemember()"
                                style="background-color: #2ab27b !important;">Submit
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
            Vue.component('my-component', {
                props: ['fname'],
                template: '<div><hr><div class="form-group">' +
                '<label class="label">Name</label>' +
                '<div class="control">' +
                '<input class="form-control" type="text" v-model="fname" name="fname"  placeholder="Name">' +
                '</div></div>' +
                '<div class="field">' +
                '<label class="label">DOB</label>' +
                '<div class="control">' +
                '<input class="form-control" type="text" v-model="dob" id="dob" placeholder="dob">' +
                '</div></div>' +
                '<div class="form-group">' +
                '<label class="label">Gender</label>' +
                '<div class="control">' +
                '<select class="form-control" type="text" v-model="gender" id="gender">' +
                '<option value="male">Male</option>' +
                '<option value="female">Female</option>' +
                '</select>' +
                '</div></div>' +
                '<div class="form-group">' +
                '<label class="label">Relation</label>' +
                '<div class="control">' +
                '<select class="form-control" id="relation" v-model="relation">' +
                '<option value="husband">Husband</option>' +
                '<option value="wife">Wife</option>' +
                '<option value="son">Son</option>' +
                '<option value="daughter">Daughter</option>' +
                '</select>' +
                '</div>' +
                '</div></div>',
                data() {

                }

            })
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
                data_list:[],
                errors: ""
            }
        },
        mounted() {
        },
        methods: {
            addMemember() {
                const vm = this
                console.info(this.fname)
                axios.post(helper.add_member_api, {
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
                    console.info(response)
                }).catch(function (error) {
                    $(".alert").show()
                    console.info(error.response.data.errors)
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
