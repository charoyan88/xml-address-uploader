<template>
    <div class="container">
        <div v-if="error_msg" class="alert alert-danger mt-2" role="alert">
            {{error_msg}}
        </div>
        <div class="row h-75 justify-content-center align-items-center">
            <div class="form-group col-md-6">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" id="inputAddress" v-model="address" placeholder="Enter Address">
            </div>
            <div class="col-md-2">
                <button v-if="isLoading" class="btn btn-primary  mt-3" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button v-else="" class="btn btn-primary btn-block mt-3" @click="find">Find</button>
            </div>
            <div v-if="addresses.length>0" class="row h-75 justify-content-center align-items-center">
                <div v-for="address in addresses" class="col-md-8">
                    <div @click="selectAddress" class="alert alert-light" role="alert"
                         v-bind:data_addresses_cord_x="address.addresses_cord_x"
                         v-bind:data_addresses_cord_y="address.addresses_cord_y">
                        {{address.addresses_street_name}} {{address.addresses_address}}
                    </div>
                </div>
            </div>
            <div v-if="groupedAddresses.length>0" class="row ">
                <div class="col-md-4">
                    <div class="alert alert-success" role="alert">
                        Distance &lt; 5 Km
                    </div>
                    <div v-for="address in groupedAddresses" v-if="address.distance<5" class="alert alert-light"
                         role="alert">
                        {{address.addresses_street_name}} {{address.addresses_address}} ({{address.distance.toFixed(1)}})
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-success" role="alert">
                        Distance From 5 Km to 30 Km
                    </div>
                    <div v-for="address in groupedAddresses" v-if="address.distance>5 && address.distance<30"
                         class="alert alert-light" role="alert">
                        {{address.addresses_street_name}} {{address.addresses_address}} ({{address.distance.toFixed(1)}})
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-success" role="alert">
                        Distance more than 30 Km
                    </div>
                    <div v-for="address in groupedAddresses" v-if="address.distance>30" class="alert alert-light"
                         role="alert">
                        {{address.addresses_street_name}} {{address.addresses_address}} ({{address.distance.toFixed(1)}})
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                base_url: `${process.env.MIX_APP_URL}/api/v1`,
                error_msg: "",
                isLoading: false,
                address: "",
                lat: "",
                lng: "",
                addresses: [],
                groupedAddresses: []
            }
        },
        methods: {
            find(){
                this.error_msg = "";
                this.success_msg = "";
                this.isLoading = true;
                let url = new URL(this.base_url + '/find'),
                    params = {
                        address: this.address,
                        lat: this.lat,
                        lng: this.lng
                    };
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
                fetch(url, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        this.isLoading = false;
                        data = JSON.parse(data);
                        if (data.status === "Error") {
                            this.error_msg = data.msg;
                        } else {
                            this.addresses = data.data;

                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            },
            selectAddress(e)
            {
                let lat = e.currentTarget.getAttribute('data_addresses_cord_x');
                let lng = e.currentTarget.getAttribute('data_addresses_cord_y');
                this.isLoading = true;
                this.addresses = [];
                let url = new URL(this.base_url + '/find/adressess'),
                    params = {
                        lat: lat,
                        lng: lng
                    };
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
                fetch(url, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        this.isLoading = false;
                        data = JSON.parse(data);
                        if (data.status === "Error") {
                            this.error_msg = data.msg;
                        } else {
                            this.groupedAddresses = data.data;

                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            },

        },
        mounted() {
            this.$getLocation()
                .then(coordinates => {
                    this.lat = coordinates.lat;
                    this.lng = coordinates.lng;
                });
        },
        components: {
            //
        }
    }
</script>
