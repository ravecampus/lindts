<template>
     <div class="modal fade notauth" ref="notauth">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                     <h6>Please access this application!</h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <!-- <div class="btn-group"> -->
                                    <button type="button" @click="linkSignin()" class="book-a-table-btn">Sign in</button>
                                    <button type="button" @click="linkSignup()" class="book-a-table-btn">Sign up</button>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            post:{},
            errors:[],
            btn:'Login',
            btndis:false,
        }
    },
    methods:{
        linkSignin(){
            $('.notauth').modal('hide');
            $('.menu-list').modal('hide');
            this.$router.push({name:'signin'});
        },
        linkSignup(){
            $('.notauth').modal('hide');
            $('.menu-list').modal('hide');
            this.$router.push({name:'signup'});
        },
    }
}
</script>

<style>

</style>
