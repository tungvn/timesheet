<template>
        <ul class="pagination justify-content-end ml-auto" v-show="tablePagination && tablePagination.last_page > 1">
            <li class="page-item" v-bind:class="[isOnFirstPage ? 'disabled' : '']">
                <a class="page-link" @click="loadPage(1)"><svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 14.5974L10 8.2987L17 2" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.17236 14.5L6.17236 2" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </a>
            </li>

            <li class="page-item" v-bind:class="[isOnFirstPage ? 'disabled' : '']">
                <a class="page-link" @click="loadPage('prev')">
                    <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 14.5974L2 8.2987L9 2" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </a>
            </li>

            <template v-if="notEnoughPages">
                <template v-for="n in totalPage">
                    <li class="page-item" v-bind:class="[isCurrentPage(n) ? 'active' : '']">
                        <a class="page-link" @click="loadPage(n)">{{ n }}</a>
                    </li>
                </template>
            </template>
            <template v-else>
                <template v-for="n in windowSize">
                    <li class="page-item" v-bind:class="[isCurrentPage(windowStart + n - 1) ? 'active' : '']">
                        <a class="page-link" @click="loadPage(windowStart + n - 1)"> {{ windowStart + n - 1 }}</a>
                    </li>
                </template>
            </template>

            <li class="page-item" v-bind:class="[isOnLastPage ? 'disabled' : '']" >
                <a class="page-link" @click="loadPage('next')">
                    <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 2.00001L9 8.29871L2 14.5974" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>

            <li class="page-item" v-bind:class="[isOnLastPage ? 'disabled' : '']" >
                <a class="page-link" @click="loadPage(totalPage)">
                    <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 2.00001L9 8.29871L2 14.5974" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.8281 2.09741L12.8281 14.5974" stroke="#003539" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
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
