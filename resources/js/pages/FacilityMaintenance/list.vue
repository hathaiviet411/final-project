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
											<span style="color: #FFFFFF;">{{ $t('FACILITY_MAINTENANCE.NEW_FACILITY') }}</span>
										</v-btn>
									</v-col>
								</v-row>
							</v-card-title>

							<v-data-table
								:headers="headers"
								:items="items"
								:search="search"
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
    name: 'FacilityManagementList',
    data() {
        return {
            FacilityList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('FACILITY_MAINTENANCE.FACILITY_NAME') + ' ⇅', sortable: true, value: 'facility_name' },
                { text: this.$t('FACILITY_MAINTENANCE.DESCRIPTION') + ' ⇅', sortable: true, value: 'description' },
                { text: this.$t('FACILITY_MAINTENANCE.STATUS') + ' ⇅', sortable: true, value: 'status' },
                { text: this.$t('FACILITY_MAINTENANCE.MAINTAINED_START_DATE') + ' ⇅', sortable: true, value: 'maintained_start_date' },
                { text: this.$t('FACILITY_MAINTENANCE.RESPONSIBLE_STAFF') + ' ⇅', sortable: true, value: 'responsible_staff' },
            ],

            items: [
                {
                    facility_name: 'Cửa chính sảnh A',
                    description: 'Cánh của chính bên phải sảnh A',
                    status: 'Hư hỏng',
                    maintained_start_date: '2020-01-01',
                    responsible_staff: 'Nguyễn Văn A',
                },
                {
                    facility_name: 'Cửa chính sảnh A',
                    description: 'Cánh của chính bên phải sảnh A',
                    status: 'Hư hỏng',
                    maintained_start_date: '2020-01-01',
                    responsible_staff: 'Nguyễn Văn A',
                },
                {
                    facility_name: 'Cửa chính sảnh A',
                    description: 'Cánh của chính bên phải sảnh A',
                    status: 'Hư hỏng',
                    maintained_start_date: '2020-01-01',
                    responsible_staff: 'Nguyễn Văn A',
                },
                {
                    facility_name: 'Cửa chính sảnh A',
                    description: 'Cánh của chính bên phải sảnh A',
                    status: 'Hư hỏng',
                    maintained_start_date: '2020-01-01',
                    responsible_staff: 'Nguyễn Văn A',
                },
            ],

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getFacilityList();
    },
    methods: {
        getFacilityList() {
            console.log('Get Facility List');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .facility-management {
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
