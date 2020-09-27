<template>
    <div>
        <div class="row">
            <div class="col-sm-3">
                <label for="input1" class="small">Enter item name and click add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="e.g Bread" id="input1"
                           aria-label="Recipient's username"
                           aria-describedby="button-addon2" v-model="item" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2" @click="addItem">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <el-transfer
            :data="itemsData"
            v-model="value"
            :titles="['Items', 'Selected']"
            @change="toggleSelected"
        >
        </el-transfer>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: [],
                value: [],
                item: '',
                description: ''
            }
        },
        async mounted() {
            // load items
            await axios.get(`/api/items`).then(response => {
                this.items = response.data.data;
            });

            this.value = this.selectedItem
        },

        computed: {
            itemsData() {
                return this.items.map(data => {
                    return {
                        key: data.id,
                        selected: data.selected,
                        label: data.name
                    };
                })
            },
            selectedItem() {
                return this.items.filter(x => x.selected).map(i => i.id);
            }
        },

        methods: {
            // add items
            addItem() {
                // validate
                const payload = {
                    'name': this.item,
                    'description': this.description
                };
                axios.post(`/api/items`, payload).then((response) => {
                    let successMessage = response.data.message;
                    this.handleAlert('success', successMessage);
                    // sync newly added item and clear input
                    this.item = '';
                    this.items.unshift(response.data.data);
                }).catch((error) => {
                    let errorMessage = error.response.data.message, errors = error.response.data.errors;
                    this.handleAlert('error', errorMessage, errors);
                });
            },
            toggleSelected(val, dir, keys) {
                console.log(val, dir, keys)
                const payload = {
                    'items': keys,
                    'dir': dir
                };
                axios.post(`/api/items/update-selected`, payload).then((response) => {
                    let successMessage = response.data.message;
                    this.handleAlert('success', successMessage);
                    this.items = (response.data.data);
                }).catch((error) => {
                    let errorMessage = error.response.data.message, errors = error.response.errors;
                    this.handleAlert('error', errorMessage, errors);
                });

            },

            handleAlert(type, message = '', errors = '') {
                switch (type) {
                    case 'error':
                        let errorMessage = `<b>${message}!</b>  ${errors}`;
                        this.$message({
                            message: errorMessage,
                            dangerouslyUseHTMLString: true,
                            type: 'error'
                        });
                        break;

                    case 'success':
                        let successMessage = `<b>${message}!</b>`;
                        this.$message({
                            message: successMessage,
                            dangerouslyUseHTMLString: true,
                            type: 'success'
                        });
                        break;
                }
            }

        }
    };
</script>
