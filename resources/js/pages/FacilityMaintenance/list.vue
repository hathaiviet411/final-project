<template>
	<div class="facility-management">
		<v-app>
			<b-overlay
				:show="overlay.show"
				:variant="overlay.variant"
				:opacity="overlay.opacity"
				:blur="overlay.blur"
				:rounded="overlay.sm"
			>
				<template #overlay>
					<div class="text-center">
						<b-icon icon="arrow-clockwise" font-scale="3" animation="spin" />
						<p style="margin-top: 10px;">{{ $t('OVERLAY.PLEASE_WAIT') }}</p>
					</div>
				</template>

				<v-row class="my-3 mx-3">
					<v-col cols="12">
						<v-card elevation="24">
							<v-card-title>
								<b-row>
									<b-col lg="6" md="12" sm="12" class="text-center">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</b-col>

									<b-col lg="6" md="12" sm="12" class="text-center mt-3">
										<v-btn class="primary-btn" dark @click="openRegisterDialog()">
											<span>{{ $t('FACILITY_MAINTENANCE.NEW_FACILITY') }}</span>
										</v-btn>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="facility-management-list-table mt-3"
								:headers="headers"
								:items="items"
								:search="search"
								item-key="facility_title"
								:header-props="{
									sortByText: $t('BUTTON.SORT_BY'),
									sortIcon: null,
								}"
								:footer-props="{
									itemsPerPageText: $t('PAGINATION.DISPLAY_PER_PAGE'),
									itemsPerPageAllText: $t('PAGINATION.ALL'),
									itemsPerPageOption: [10, 20, 50, 100, -1]
								}"
							>
								<template #[`item.actions`]="{ item }">
									<v-row>
										<v-col cols="6" class="text-right">
											<v-icon small class="text-primary" @click="getSpecificFacility(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="6" class="text-left">
											<v-icon small class="text-danger" @click="deleteDialog = true, deleting_id = item.id">fas fa-trash-alt</v-icon>
										</v-col>
									</v-row>
								</template>

								<template #[`item.status`]="{ item }">
									<span>{{ convertFromIDToName(item.status, ListStatus) }}</span>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="500" scrollable persistent>
					<v-card max-height="620">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('FACILITY_MAINTENANCE.NEW_FACILITY') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="facility.facility_title"
										:label="$t('FACILITY_MAINTENANCE.FACILITY_TITLE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="facility.facility_detail"
										:label="$t('FACILITY_MAINTENANCE.FACILITY_DETAIL')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="facility.user_id"
										:items="ListUser"
										:label="$t('FACILITY_MAINTENANCE.RESPONSIBLE_STAFF')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectStartDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="facility.start_date"
												:label="$t('FACILITY_MAINTENANCE.START_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="facility.start_date"
											show-current
											:max="facility.end_date"
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="dialogSelectStartDate = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectEndDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="facility.end_date"
												:label="$t('FACILITY_MAINTENANCE.END_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="facility.end_date"
											show-current
											:min="facility.start_date"
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="dialogSelectEndDate = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="facility.status"
										:items="ListStatus"
										:label="$t('FACILITY_MAINTENANCE.STATUS.TITLE')"
										outlined
									/>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="registerDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doRegisterFacility()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.REGISTER') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Edit Dialog -->
				<v-dialog v-model="editDialog" max-width="500" scrollable persistent>
					<v-card max-height="620">
						<v-btn elevation="3" block tile class="mb-3 cornflower" @click="editDialog = true">
							<span>{{ $t('FACILITY_MAINTENANCE.EDIT_FACILITY') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="facility.facility_title"
										:label="$t('FACILITY_MAINTENANCE.FACILITY_TITLE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="facility.facility_detail"
										:label="$t('FACILITY_MAINTENANCE.FACILITY_DETAIL')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="facility.user_id"
										:items="ListUser"
										:label="$t('FACILITY_MAINTENANCE.RESPONSIBLE_STAFF')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectStartDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="facility.start_date"
												:label="$t('FACILITY_MAINTENANCE.START_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="facility.start_date"
											show-current
											:max="facility.end_date"
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="dialogSelectStartDate = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectEndDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="facility.end_date"
												:label="$t('FACILITY_MAINTENANCE.END_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="facility.end_date"
											show-current
											:locale="language"
											:min="facility.start_date"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="dialogSelectEndDate = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="facility.status"
										:items="ListStatus"
										:label="$t('FACILITY_MAINTENANCE.STATUS.TITLE')"
										outlined
									/>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="editDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doUpdateFacility(facility.id)">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.SAVE') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Delete Dialog -->
				<v-dialog v-model="deleteDialog" max-width="500" persistent>
					<v-card>
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('FACILITY_MAINTENANCE.DELETE_FACILITY') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12" class="text-center">
									<h5>{{ $t('MODAL.DELETE_CONFIRMATION') }}</h5>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="deleteDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('MODAL.NO') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="doRemoveFacility(deleting_id)">
										<v-icon left>fas fa-eraser</v-icon>
										<span>{{ $t('MODAL.YES') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</b-overlay>
		</v-app>
	</div>
</template>

<script>
import {
    getAllFacility,
    getOneFacility,
    createFacility,
    updateFacility,
    deleteFacility,
}
from '@/api/modules/facility-maintenance';

import { MakeToast } from '@/utils/MakeToast';

import { getYMDFromString } from '@/utils/getYMDFromString';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

const urlAPI = {
    apiGetAllFacility: '/facility-maintenance/list',
    apiGetAllStaff: '/auth/user',
    apiGetOneFacility: '/facility-maintenance/detail/',
    apiCreateFacility: '/facility-maintenance/create',
    apiUpdateFacility: '/facility-maintenance/update/',
    apiDeleteFacility: '/facility-maintenance/delete/',
};

export default {
    name: 'FacilityManagementList',
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            convertFromIDToName: convertFromIDToName,

            facility: {
                facility_title: '',
                facility_detail: '',
                user_id: 1,
                start_date: '',
                end_date: '',
                status: null,
            },

            headers: [
                { text: this.$t('FACILITY_MAINTENANCE.FACILITY_TITLE'), sortable: false, value: 'facility_title' },
                { text: this.$t('FACILITY_MAINTENANCE.FACILITY_DETAIL'), sortable: false, value: 'facility_detail' },
                { text: this.$t('FACILITY_MAINTENANCE.START_DATE'), sortable: false, value: 'start_date' },
                { text: this.$t('FACILITY_MAINTENANCE.END_DATE'), sortable: false, value: 'end_date' },
                { text: this.$t('FACILITY_MAINTENANCE.RESPONSIBLE_STAFF'), sortable: false, value: 'user_id' },
                { text: this.$t('FACILITY_MAINTENANCE.STATUS.TITLE'), sortable: false, value: 'status' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            ListUser: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            ListStatus: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('FACILITY_MAINTENANCE.STATUS.PENDING') },
                { value: 2, text: this.$t('FACILITY_MAINTENANCE.STATUS.MAINTAINING') },
                { value: 3, text: this.$t('FACILITY_MAINTENANCE.STATUS.FINISHED') },
            ],

            search: '',

            dialogSelectStartDate: false,

            dialogSelectEndDate: false,

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getFacilityList();
    },
    methods: {
        async getFacilityList() {
            this.overlay.show = true;

            try {
                const response = await getAllFacility(urlAPI.apiGetAllFacility);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        response.data[i].start_date = getYMDFromString(response.data[i].start_date);
                        response.data[i].end_date = getYMDFromString(response.data[i].end_date);
                    }

                    this.items = response.data;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.TITLE.ERROR'),
                });
            }

            this.overlay.show = false;
        },

        async getSpecificFacility(facility_id) {
            this.facility = {
                facility_title: '',
                facility_detail: '',
                user_id: 1,
                start_date: '',
                end_date: '',
                status: null,
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneFacility}${facility_id}`;

            try {
                const response = await getOneFacility(URL);

                if (response.code === 200) {
                    response.data.start_date = getYMDFromString(response.data.start_date);
                    response.data.end_date = getYMDFromString(response.data.end_date);
                    this.facility = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.facility = {
                facility_title: '',
                facility_detail: '',
                user_id: 1,
                start_date: '',
                end_date: '',
                status: null,
            };

            this.registerDialog = true;
        },

        async doRegisterFacility() {
            try {
                const response = await createFacility(urlAPI.apiCreateFacility, this.facility);

                if (response.code === 201) {
                    await this.getFacilityList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.CREATE_FACILITY_SUCCESS'),
                    });

                    this.registerDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.CREATE_FACILITY_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateFacility(facility_id) {
            const URL = `${urlAPI.apiUpdateFacility}${facility_id}`;

            try {
                const response = await updateFacility(URL, this.facility);

                if (response.code === 200) {
                    await this.getFacilityList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.UPDATE_FACILITY_SUCCESS'),
                    });

                    this.editDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.UPDATE_FACILITY_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveFacility(facility_id) {
            const URL = `${urlAPI.apiDeleteFacility}${facility_id}`;

            try {
                const response = await deleteFacility(URL);
                if (response.code === 200) {
                    this.getFacilityList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.DELETE_FACILITY_SUCCESS'),
                    });

                    this.deleteDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FACILITY_MAINTENANCE.DELETE_FACILITY_FAILED'),
                });

                this.deleteDialog = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .facility-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .facility-management-list-table {
      ::v-deep th {
        font-weight: bolder !important;
        color: $white !important;
        background-color: $cloud-burst;
      }

      ::v-deep th {
        text-align: center !important;
      }

      ::v-deep td {
        text-align: center !important;
      }
    }
  }

  @media (max-width: 768px) {
    .facility-management {
      max-height: 100%;
    }
  }
</style>
