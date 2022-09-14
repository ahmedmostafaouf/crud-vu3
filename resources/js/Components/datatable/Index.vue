<template>
  <div class="row">
    <div class="col-12">
      <div>
        <!-- table -->
          <vue-good-table
              mode="remote"
              :total-rows="totalRecords"
              :is-loading="isLoading"
              :rows="rows"
              :columns="columns"
              :pagination-options="{enabled: true,perPage: pageLength}"
              :sort-options="{enabled: true}"
              :select-options="{
                enabled: true,
                selectOnCheckboxOnly: true,
                selectionInfoClass: 'custom-class',
                selectionText: 'rows selected',
                clearSelectionText: 'clear',
                disableSelectInfo: true,
                selectAllByGroup: true,
           }"
              @on-select-all="onSelectAll"
              v-on:selected-rows-change="onSelectAll"
              v-on:sort-change="onSortChange"
              v-on:per-page-change="onPerPageChange"
              v-on:page-change="onPageChange"
          >


                  <span >
                      <span>
                          <slot
                               name="actions"
                              :row="props.row"
                          />
                      </span>
                 </span>
          </vue-good-table>
          <div class="mb-3">
              <div  class="d-flex justify-content-between flex-wrap" >

                  <!-- pagination -->
                  <div class="md-3">
                      <b-pagination
                          :value="1"
                          :total-rows="totalRecords"
                          :per-page="pageLength"
                          first-number
                          last-number
                          align="right"
                          prev-class="prev-item"
                          next-class="next-item"
                          class="mt-1 mb-0"
                          @change="onPageChange"
                      >
                          <template #prev-text>
                              <i
                                  class="fa fa-chevron-left"
                              ></i>
                          </template>
                          <template #next-text>
                              <i
                                  class="fa fa-chevron-right"
                              ></i>
                          </template>
                      </b-pagination>

                  </div>
              </div>
          </div>


      </div>
    </div>
  </div>
</template>

<script>

import { VueGoodTable } from 'vue-good-table-next'
import axios from 'axios'
import 'vue-good-table-next/dist/vue-good-table-next.css'
export default {
  components: {
    VueGoodTable,

  },
  props: ['columnsProp', 'titleProp', 'url', 'searchTermProp','datatableFilter'],
    data() {
        return {
            isLoading: false,
            searchTerm: '',
            pageLength: 10,
            pages: ["1","10", "20", "50", "100", "1000"],
            columns: [],
            rows: [],
            totalRecords: 0,
            serverParams: {
                columnFilters: {},
                sort:
                    {
                        field: 'name',
                        type: 'desc',
                    },
                page: 1,
                perPage: 10,
            },
        }
    },
  computed: {
  },
  watch: {
    searchTermProp(val) {
      this.searchTerm = val
      this.loadItems()
    },
      datatableFilter(val){
      let url =`${this.url}?searchTerm=${this.searchTerm}&page=${this.serverParams.page}&per_page=${this.serverParams.perPage}&field=${this.serverParams.sort.field}&type=${this.serverParams.sort.type}` +val;
      this.loadItems(url);
      },
  },
  mounted() {
    this.columns = this.columnsProp
    this.loadItems()
   // this.$emit.$on('deleted',()=>{
   //        this.loadItems();
   //    })
  },
  methods: {

          updateParams(newProps) {
              this.serverParams = {...this.serverParams, ...newProps}
          },
          onPageChange(val) {
              this.serverParams.page = val.currentPage
              this.loadItems()
          },
          onSelectAll(params) {
              this.$emit('getselected', params)
          },

          onPerPageChange(page) {
              this.serverParams.perPage = page.currentPerPage
              this.loadItems()
          },
          onSortChange(params) {
              if (params[0].type === 'none') {
                  params[0].type = 'asc'
              }
              this.updateParams({
                  sort: {
                      type: params[0].type,
                      field: params[0].field,
                  },
              })
              this.loadItems()
          },
          loadItems(url = '') {
              this.isLoading = true
              url = url ? url : `${this.url}?searchTerm=${this.searchTerm}&page=${this.serverParams.page}&per_page=${this.serverParams.perPage}&field=${this.serverParams.sort.field}&type=${this.serverParams.sort.type}`
              axios.get(url).then(response => {
                  this.isLoading = false
                  this.rows = response.data.data
                  this.totalRecords = response.data.meta.total
              }).catch(err => {
                  this.isLoading = false
              })
          },
      },


}
</script>
<style  >
.website{
    display: flex!important;
}
</style>
