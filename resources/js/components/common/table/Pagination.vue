<template>
    <ul class="pagination justify-content-end ml-auto" v-show="tablePagination && tablePagination.last_page > 1">
        <li class="page-item" v-bind:class="[isOnFirstPage ? 'disabled' : '']">
            <a @click="loadPage(1)" class="page-link">
                <svg fill="none" height="16" viewBox="0 0 19 16" width="19" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 14.5974L10 8.2987L17 2" stroke="#003539" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5"/>
                    <path d="M6.17236 14.5L6.17236 2" stroke="#003539" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5"/>
                </svg>
            </a>
        </li>

        <li class="page-item" v-bind:class="[isOnFirstPage ? 'disabled' : '']">
            <a @click="loadPage('prev')" class="page-link">
                <svg fill="none" height="16" viewBox="0 0 11 16" width="11" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 14.5974L2 8.2987L9 2" stroke="#003539" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5"/>
                </svg>

            </a>
        </li>

        <template v-if="notEnoughPages">
            <template v-for="n in totalPage">
                <li class="page-item" v-bind:class="[isCurrentPage(n) ? 'active' : '']">
                    <a @click="loadPage(n)" class="page-link">{{ n }}</a>
                </li>
            </template>
        </template>
        <template v-else>
            <template v-for="n in windowSize">
                <li class="page-item" v-bind:class="[isCurrentPage(windowStart + n - 1) ? 'active' : '']">
                    <a @click="loadPage(windowStart + n - 1)" class="page-link"> {{ windowStart + n - 1 }}</a>
                </li>
            </template>
        </template>

        <li class="page-item" v-bind:class="[isOnLastPage ? 'disabled' : '']">
            <a @click="loadPage('next')" class="page-link">
                <svg fill="none" height="16" viewBox="0 0 11 16" width="11" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2.00001L9 8.29871L2 14.5974" stroke="#003539" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2.5"/>
                </svg>
            </a>
        </li>

        <li class="page-item" v-bind:class="[isOnLastPage ? 'disabled' : '']">
            <a @click="loadPage(totalPage)" class="page-link">
                <svg fill="none" height="17" viewBox="0 0 21 17" width="21" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2.00001L9 8.29871L2 14.5974" stroke="#003539" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2.5"/>
                    <path d="M12.8281 2.09741L12.8281 14.5974" stroke="#003539" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2.5"/>
                </svg>
            </a>
        </li>
    </ul>
</template>

<script>
    import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin'

    export default {
        mixins: [PaginationMixin]
    }
</script>
