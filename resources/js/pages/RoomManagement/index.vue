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
						<v-card elevation="24" min-height="700">
							<v-card-title>
								<v-row>
									<v-col lg="10" sm="12">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</v-col>

									<v-col lg="2" sm="12" class="text-center">
										<v-btn color="#1e2a55" dark class="mt-3">
											<span style="color: #FFFFFF;">{{ $t('STAFF_MANAGEMENT.NEW_STAFF') }}</span>
										</v-btn>
									</v-col>
								</v-row>
							</v-card-title>

							<v-data-table
								:headers="headers"
								:items="items"
								:search="search"
								item-key="staff_name"
								sort-by="staff_name"
								:header-props="{
									sortByText: $t('BUTTON.SORT_BY'),
									sortIcon: null,
								}"
								:footer-props="{
									itemsPerPageText: $t('PAGINATION.DISPLAY_PER_PAGE'),
									itemsPerPageAllText: $t('PAGINATION.ALL'),
									itemsPerPageOption: [10, 20, 50, 100, -1]
								}"
							/>
						</v-card>
					</v-col>
				</v-row>
			</b-overlay>
		</v-app>
	</div>
</template>

<script>
export default {
    name: 'RoomManagementIndex',
    data() {
        return {
            RoomList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('ROOM_MANAGEMENT.ROOM_NUMBER') + ' ⇅', sortable: true, value: 'room_number' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_TYPE') + ' ⇅', sortable: true, value: 'room_type' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_STATUS') + ' ⇅', sortable: true, value: 'room_status' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_CAPACITY') + ' ⇅', sortable: true, value: 'room_capacity' },
                { text: this.$t('ROOM_MANAGEMENT.LEVEL') + ' ⇅', sortable: true, value: 'level' },
                { text: this.$t('ROOM_MANAGEMENT.ROOM_INFORMATION'), sortable: false, value: 'room_information' },
                { text: this.$t('ROOM_MANAGEMENT.BUILDING') + ' ⇅', sortable: true, value: 'building' },
            ],

            items: [
                {
                    room_number: 302,
                    room_type: 'Classic',
                    room_status: 'Empty',
                    room_capacity: '2',
                    level: 3,
                    room_information: 'Cat',
                    building: 'Toà C',
                },
                {
                    room_number: 102,
                    room_type: 'Luxury',
                    room_status: 'In use',
                    room_capacity: '1',
                    level: 1,
                    room_information: 'Dog',
                    building: 'Toà A',
                },
            ],

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getRoomList();
    },
    methods: {
        getRoomList() {
            console.log('Get Room List');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import '@/scss/variables.scss';

  .room-management {
    ::v-deep th {
      font-size: 14px !important;
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
</style>
