<template>
    <div class="container py-5 m-top">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h6 class="text-white">Book your Orders</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small mb-1" >Full Name</label>
                            <input class="form-control" v-model="post.full_name" type="text" placeholder="Enter your Full name">
                            <span class="errors-material" v-if="errors.full_name">{{errors.full_name[0]}}</span>
                        </div>
                         <div class="mb-3">
                            <label class="small mb-1" >Mobile Number</label>
                            <input class="form-control" v-model="post.mobile_number" type="text" placeholder="Enter your Mobile Number">
                            <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" >Number Of Person</label>
                            <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Enter your Number of Person">
                            <span class="errors-material" v-if="errors.number_of_person">{{errors.number_of_person[0]}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" >Reservation Date</label>
                            <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Enter your Reservation Date">
                            <span class="errors-material" v-if="errors.reservation_date">{{errors.reservation_date[0]}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" >Reservation Time</label>
                            <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Enter your Reservation Date">
                            <span class="errors-material" v-if="errors.reservation_time">{{errors.reservation_time[0]}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" >Select our </label>
                            <button type="button" class="book-a-table-btn btn-sm-table">Menu</button>
                            <!-- <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Enter your Reservation Date"> -->
                            <!-- <span class="errors-material" v-if="errors.reservation_time">{{errors.reservation_time[0]}}</span> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8"></div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            post:{},
            errors:[]
        }
    }
}
</script>

<style>

</style>
