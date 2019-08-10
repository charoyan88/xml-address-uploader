<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">File Upload Component</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input  v-on:change="onChange" type="file" class="custom-file-input" id="inputGroupFile04">
                                        <label class="custom-file-label" for="inputGroupFile04">{{file_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button v-if="isLoading" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button v-else="" class="btn btn-primary btn-block" @click="uploadXml">Upload Image</button>
                            </div>
                            <div v-if="error_msg" class="col-md-6 mt-2">
                                <div class="alert alert-danger" role="alert">
                                    {{error_msg}}
                                </div>
                            </div>
                            <div v-if="success_msg" class="col-md-6 mt-2">
                                <div class="alert alert-success" role="alert">
                                    {{success_msg}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                base_url: `${process.env.MIX_APP_URL}/api/v1`,
                xml: "",
                error_msg: "",
                success_msg: "",
                isLoading:false,
                file_name: "Choose file",
            }
        },
        methods: {
            onChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                if (files[0]['type'] == 'text/xml') {
                    this.file_name = files[0].name;
                    this.createXml(files[0]);
                } else {
                    this.error_msg = "You can upload only xml file"
                }

            },
            createXml(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.xml = e.target.result;
                };
                reader.readAsText(file);
            },
            uploadXml(){
                this.error_msg = "";
                this.success_msg = "";
                this.isLoading=true;
                let convert = require('xml-js');
                let result = convert.xml2json(this.xml, {compact: true, spaces: 4});
                let req = JSON.parse(result).roomservice.addresses;
                fetch(this.base_url + '/upload/xml', {
                    method: 'POST',
                    body: JSON.stringify({xml: req}),
                    headers: {
                        'Content-Type': 'application/json'
                    }

                }).then((res) => res.text())
                    .then((data) => {
                        this.isLoading = false;
                        data = JSON.parse(data);
                        if (data.status === "Error") {
                            this.error_msg = data.msg;
                            console.log(this.error_msg)
                        } else {
                            this.success_msg = data.msg;
                            console.log(this.success_msg)
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            },
        },
        mounted(){

        }
    }
</script>