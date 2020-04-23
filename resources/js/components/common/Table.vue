<template>
    <div class="table-responsive w-full">
        <vuetable ref="vuetable"
                  :api-mode="true"
                  :api-url="apiUrl"
                  :http-fetch="httpFetch"
                  :fields="fields"
                  :css="{
							tableClass: 'table table-hover',
							loadingClass: 'loading',
							ascendingIcon: 'fas fa-caret-up',
							descendingIcon: 'fas fa-caret-down',
							detailRowClass: 'vuetable-detail-row',
							sortHandleIcon: 'grey sidebar icon',
							sortableIcon: 'fas fa-sort',
					  }"
                  pagination-path="meta"
                  :no-data-template="isLoading ? 'Loading...' : 'No items found'"
                  @vuetable:pagination-data="onPaginationData"
                  @vuetable:loading="setLoading(true)"
                  @vuetable:loaded="setLoading(false)"

        >
            <div slot="admin" slot-scope="props">
                <span v-if="isAdmin(props.rowData)">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
                              d="M4.48637 10.1203C4.14663 9.78094 3.59455 9.78094 3.25481 10.1203C2.91506 10.4596 2.91506 11.011 3.25481 11.3504L7.26801 15.3587C7.43788 15.5284 7.65022 15.6132 7.88379 15.6132C7.90503 15.6132 7.90503 15.6132 7.92626 15.6132C8.15983 15.592 8.39341 15.486 8.56328 15.2951L17.3436 5.42675C17.6409 5.0662 17.5984 4.51479 17.2374 4.19666C16.8764 3.89975 16.3244 3.94216 16.0059 4.3027L7.82009 13.45L4.48637 10.1203Z"
                              fill="#003539" stroke="#003539" stroke-width="0.5"/>
					</svg>
                </span>
            </div>

            <template slot="actions" slot-scope="props">
                <div class="d-flex align-items-center justify-content-end">
                    <router-link
                        class="mr-1 btn btn-sm btn-outline-success"
                        title="Edit"
                        :style="{ fontSize: '12px' }"
                        :to="`/user/${props.rowData.id}`"
                    >
                        <icon icon="edit"/>
                    </router-link>
                    <button
                        type="button"
                        title="Delete"
                        class="btn btn-sm btn-outline-danger btn-icon-delete"
                        :style="{ fontSize: '12px' }"
                        @click="confirmDelete(props.rowData)"
                    >
                        <icon icon="trash"/>
                    </button>
                </div>
            </template>
        </vuetable>

        <pagination ref="pagination" @vuetable-pagination:change-page="onChangePage"/>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import request from 'common/request';
    import {ROLE_ADMIN} from 'common/constant';
    import Pagination from './Pagination';

    export default {
        components: {
            Vuetable,
            Pagination
        },

        props: {
            fields: {
                type: Array,
                required: true
            },

            apiUrl: {
                type: String,
                required: true
            },

            deleteFunc: {
                type: Function,
                default() {
                    return (id) => {
                    };
                },
            }
        },

        data() {
            return {
                isLoading: false,
                showDeleteConfirmationModel: false,
                selectedItem: null,
            };
        },

        methods: {
            /**
             * Set loading status
             * @param {Boolean} value
             */
            setLoading(value) {
                this.isLoading = value;
            },

            httpFetch(api, httpOptions) {
                return request.get(api, {params: httpOptions.params});
            },

            /**
             * Set table pagination retrieve from vuetable
             * @param {Object} tablePagination
             */
            onPaginationData(tablePagination) {
                this.$refs.pagination.setPaginationData(tablePagination);
            },

            /**
             * Update change page to Vuetable
             * @param {any} page
             */
            onChangePage(page) {
                this.isLoading = true;
                this.$refs.vuetable.changePage(page);
            },

            confirmDelete(row) {
                this.showDeleteConfirmationModel = true;
                this.selectedItem = row.id;
            },

            resetDeleteItem() {
                this.selectedItem = null;
                this.showDeleteConfirmationModel = false;
            },

            /**
             * Delete item
             */
            deleteItem() {
                this.isLoading = true;

                return this.deleteFunc(this.selectedItem)
                    .then(response => {
                        this.resetDeleteItem();
                        this.$toasted.success('Delete successful');
                        this.$refs.vuetable.reload();
                    })
                    .catch(error => {
                        this.resetDeleteItem();
                        let msg = ``;

                        if (error.response && error.response.data && error.response.data.errors) {
                            for (let field in error.response.data.errors) {
                                if (error.response.data.errors[field][0]) {
                                    msg += error.response.data.errors[field][0];
                                }
                            }
                        } else {
                            msg = `Cannot delete ${this.type}`;
                        }

                        this.$toasted.error(msg);
                        this.isLoading = false;
                    });
            },

            forceRefresh() {
                this.$refs.vuetable.resetData();
                Vue.nextTick(() => this.refresh());
            },

            /**
             * Refresh table with data
             */
            refresh() {
                this.$refs.vuetable.refresh();
            },

            isAdmin(rowData) {
                return rowData.role === ROLE_ADMIN;
            },
        },
    }
</script>
