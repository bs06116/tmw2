<template>
    <div class="container">
        <div class="card">
            <div class="card-content" >
                <div class="field">
                    <label class="label">Book Number</label>
                    <div class="control">
                        {{book_number}}
                    </div>
                </div>
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        {{name}} <b>(HEAD)</b>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        {{email}}
                    </div>
                </div>
                <div class="field">
                    <label class="label">Address</label>
                    <div class="control">
                        {{address}}
                    </div>
                </div>
                <div class="field">
                    <label class="label">Telephone</label>
                    <div class="control">
                        {{telephone}}
                    </div>
                </div>
                <div class="field">
                    <label class="label">PostCode</label>
                    <div class="control">
                        {{postcode}}
                    </div>
                </div>
                <br>
                <br>
                <hr>
                <b>Sub Head</b>
                <div v-for="sh in sub_head">
                    <button class="btn-info move_new_file" :disabled='sh.status==0' v-if="sh.status=='son' || sh.status=='daughter'">Over 18 - Moved to new file </button>
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            {{sh.name}}
                        </div>

                    </div>
                    <div class="field">
                        <label class="label">Gender</label>
                        <div class="control">
                            {{sh.gender}}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">DOB</label>
                        <div class="control">
                            {{sh.dob}}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Relation</label>
                        <div class="control">
                            {{sh.relation}}
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
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
            return {
                book_number: "",
                name: "",
                email: "",
                head_relation: "",
                address: "",
                postcode: "",
                telephone: "",
                sub_head:[],
            }
        },
        mounted() {
            this.detailMember()
        },
        methods: {
            detailMember() {
                this.id=this.$route.params.memberId;
                const vm = this
                  axios.post(helper.details_member_api, {
                      id:this.id
                }).then(response => response.data).then(response => {
                      this.book_number=response.member_relation.book_number,
                      this.name=response.member_relation.name,
                      this.email=response.member_relation.email,
                      this.head_relation=response.member_relation.head_relation,
                      this.address=response.member_relation.address,
                      this.postcode=response.member_relation.postcode,
                      this.telephone=response.member_relation.telephone,
                      this.sub_head=response.user_relation
                }).catch(function (error) {
                    vm.errors = error.response.data.errors
                });
            },
        },


    }
</script>
