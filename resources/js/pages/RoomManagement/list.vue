<template>
	<div class="room-management">
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
										<v-btn dark class="primary-btn" @click="openRegisterDialog()">
											<span>{{ $t('ROOM_MANAGEMENT.NEW_ROOM') }}</span>
										</v-btn>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="room-management-list-table mt-3"
								:headers="headers"
								:items="items"
								:search="search"
								item-key="room_number"
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
											<v-icon small class="text-primary" @click="getSpecificRoom(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="6" class="text-left">
											<v-icon small class="text-danger" @click="deleteDialog = true, deleting_id = item.id">fas fa-trash-alt</v-icon>
										</v-col>
									</v-row>

								</template>

								<template #[`item.room_type`]="{ item }">
									<span>{{ convertFromIDToName(item.room_type, RoomTypes) }}</span>
								</template>

								<template #[`item.room_status`]="{ item }">
									<span>{{ convertFromIDToName(item.room_status, RoomStatus) }}</span>
								</template>

								<template #[`item.room_capacity`]="{ item }">
									<span>{{ convertFromIDToName(item.room_capacity, RoomCapacity) }}</span>
								</template>

								<template #[`item.level`]="{ item }">
									<span>{{ convertFromIDToName(item.level, Levels) }}</span>
								</template>

								<template #[`item.building_id`]="{ item }">
									<span>{{ convertFromIDToName(item.building_id, Buildings) }}</span>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="500" scrollable persistent>
					<v-card max-height="620">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('ROOM_MANAGEMENT.NEW_ROOM') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="room.room_number"
										:label="$t('ROOM_MANAGEMENT.ROOM_NUMBER')"
										outlined
										type="number"
										@input="() => { room.level = room.room_number.substring(0, 1) }"
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_type"
										:items="RoomTypes"
										:label="$t('ROOM_MANAGEMENT.ROOM_TYPE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_status"
										:items="RoomStatus"
										:label="$t('ROOM_MANAGEMENT.ROOM_STATUS')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_capacity"
										:items="RoomCapacity"
										:label="$t('ROOM_MANAGEMENT.ROOM_CAPACITY')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="room.level"
										:label="$t('ROOM_MANAGEMENT.LEVEL')"
										disabled
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="room.room_information"
										:label="$t('ROOM_MANAGEMENT.ROOM_INFORMATION')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.building_id"
										:items="Buildings"
										:label="$t('ROOM_MANAGEMENT.BUILDING')"
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
									<v-btn class="primary-btn" @click="doRegisterRoom()">
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
							<span>{{ $t('ROOM_MANAGEMENT.EDIT_ROOM') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="room.room_number"
										:label="$t('ROOM_MANAGEMENT.ROOM_NUMBER')"
										outlined
										type="number"
										@input="() => { room.level = room.room_number.substring(0, 1) }"
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_type"
										:items="RoomTypes"
										:label="$t('ROOM_MANAGEMENT.ROOM_TYPE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_status"
										:items="RoomStatus"
										:label="$t('ROOM_MANAGEMENT.ROOM_STATUS')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.room_capacity"
										:items="RoomCapacity"
										:label="$t('ROOM_MANAGEMENT.ROOM_CAPACITY')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="room.level"
										:label="$t('ROOM_MANAGEMENT.LEVEL')"
										disabled
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="room.room_information"
										:label="$t('ROOM_MANAGEMENT.ROOM_INFORMATION')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="room.building_id"
										:items="Buildings"
										:label="$t('ROOM_MANAGEMENT.BUILDING')"
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
									<v-btn class="primary-btn" @click="doUpdateRoom(room.id)">
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
							<span>{{ $t('ROOM_MANAGEMENT.DELETE_ROOM') }}</span>
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
									<v-btn class="danger-btn" @click="doRemoveRoom(deleting_id)">
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
    getAllRoom,
    getOneRoom,
    createRoom,
    updateRoom,
    deleteRoom,
}
from '@/api/modules/room';

import { getAllBuilding } from '@/api/modules/building';

import { MakeToast } from '@/utils/MakeToast';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

const urlAPI = {
    apiGetAllRoom: '/room/list',
    apiGetAllBuilding: '/building/list',
    apiGetOneRoom: '/room/detail/',
    apiCreateRoom: '/room/create',
    apiUpdateRoom: '/room/update/',
    apiDeleteRoom: '/room/delete/',
};
export default {
    name: 'RoomManagementIndex',
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

            RoomTypes: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: 'Standard' },
                { value: 2, text: 'Superior' },
                { value: 3, text: 'Deluxe' },
                { value: 4, text: 'Suite' },
                { value: 5, text: 'Junior Suite' },
                { value: 6, text: 'Executive Suite' },
            ],

            RoomStatus: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: 'Maintaining' },
                { value: 2, text: 'Busy' },
                { value: 3, text: 'Ready' },
            ],

            RoomCapacity: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: 'Single Bed' },
                { value: 2, text: 'Double Bed' },
                { value: 3, text: 'Queen Size Bed' },
                { value: 4, text: 'King Size Bed' },
            ],

            Levels: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: '1' },
                { value: 2, text: '2' },
                { value: 3, text: '3' },
                { value: 4, text: '4' },
                { value: 5, text: '5' },
                { value: 6, text: '6' },
                { value: 7, text: '7' },
                { value: 8, text: '8' },
                { value: 9, text: '9' },
                { value: 10, text: '10' },
            ],

            Buildings: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: 'Toà A' },
            ],

            room: {
                room_number: '',
                building_id: null,
                room_type: null,
                room_capacity: null,
                level: null,
                room_information: '',
                room_status: null,
            },

            headers: [
                { text: this.$t('ROOM_MANAGEMENT.ROOM_NUMBER'), sortable: false, value: 'room_number' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_TYPE'), sortable: false, value: 'room_type' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_STATUS'), sortable: false, value: 'room_status' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_CAPACITY'), sortable: false, value: 'room_capacity' },
                { text: this.$t('ROOM_MANAGEMENT.LEVEL'), sortable: false, value: 'level' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_INFORMATION'), sortable: false, value: 'room_information' },
                { text: this.$t('ROOM_MANAGEMENT.BUILDING'), sortable: false, value: 'building_id' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            search: '',

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getRoomManagementData();
    },
    methods: {
        async getRoomManagementData() {
            await this.getRoomList();
            await this.getListBuilding();
        },

        async getRoomList() {
            this.overlay.show = true;

            try {
                const response = await getAllRoom(urlAPI.apiGetAllRoom);

                if (response.code === 200) {
                    this.items = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getListBuilding() {
            try {
                const response = await getAllBuilding(urlAPI.apiGetAllBuilding);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.Buildings.push({
                            text: response.data[i].building_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }

            this.overlay.show = false;
        },

        async getSpecificRoom(room_id) {
            this.room = {
                room_number: '',
                building_id: null,
                room_type: null,
                room_capacity: null,
                level: null,
                room_information: '',
                room_status: null,
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneRoom}${room_id}`;

            try {
                const response = await getOneRoom(URL);

                if (response.code === 200) {
                    this.room = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.room = {
                room_number: '',
                building_id: null,
                room_type: null,
                room_capacity: null,
                level: null,
                room_information: '',
                room_status: null,
            };

            this.registerDialog = true;
        },

        async doRegisterRoom() {
            try {
                const response = await createRoom(urlAPI.apiCreateRoom, this.room);

                if (response.code === 201) {
                    this.registerDialog = false;

                    await this.getRoomManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.CREATE_ROOM_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.CREATE_ROOM_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateRoom(room_id) {
            const URL = `${urlAPI.apiUpdateRoom}${room_id}`;

            try {
                const response = await updateRoom(URL, this.room);

                if (response.code === 200) {
                    this.editDialog = false;

                    await this.getRoomManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.UPDATE_ROOM_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.UPDATE_ROOM_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveRoom(room_id) {
            const URL = `${urlAPI.apiDeleteRoom}${room_id}`;

            try {
                const response = await deleteRoom(URL);
                if (response.code === 200) {
                    this.deleteDialog = false;

                    this.getRoomManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.DELETE_ROOM_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.ROOM_MANAGEMENT.DELETE_ROOM_FAILED'),
                });

                this.deleteDialog = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import '@/scss/variables.scss';

  .room-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .room-management-list-table {
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
    .room-management {
      max-height: 100%;
    }
  }
</style>
