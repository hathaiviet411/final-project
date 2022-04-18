<template>
	<div class="department-management">
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
									<v-col lg="4" sm="12">
										<v-card elevation="3">
											<vHeaderPage>{{ 'Tổng số phòng ban: ⭐ 24' }}</vHeaderPage>
										</v-card>
									</v-col>

									<v-col lg="5" sm="12">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</v-col>

									<v-col lg="3" sm="12" class="text-center">
										<v-btn color="#1e2a55" dark block class="mt-3" @click="registerDialog = true">
											<span style="color: #FFFFFF;">{{ $t('DEPARTMENT_MANAGEMENT.NEW_DEPARTMENT') }}</span>
										</v-btn>
									</v-col>
								</v-row>
							</v-card-title>

							<v-data-table
								class="department-management-list-table"
								:headers="headers"
								:items="items"
								:search="search"
								item-key="department_name"
								sort-by="department_name"
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

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="800px" persistent no-click-animation>
					<v-card>
						<v-card-title>
							<span>Cat</span>
						</v-card-title>

						<v-card-text>
							<v-row>
								<!-- Department Name -->
								<v-col cols="12" sm="6" md="6">
									<v-text-field
										v-model="department.name"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_NAME')"
										solo
									>
										<template #prepend-inner>
											<v-icon small :color="prependIconColor">fas fa-building</v-icon>
										</template>
									</v-text-field>
								</v-col>

								<!-- Department Address -->
								<v-col cols="12" sm="6" md="6">
									<v-text-field
										v-model="department.address"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_ADDRESS')"
										solo
									>
										<template #prepend-inner>
											<v-icon small :color="prependIconColor">fas fa-map-marker-alt</v-icon>
										</template>
									</v-text-field>
								</v-col>

								<!-- Department Manager -->
								<v-col cols="12" sm="6" md="6">
									<v-text-field
										v-model="department.manager"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_MANAGER')"
										solo
									>
										<template #prepend-inner>
											<v-icon small :color="prependIconColor">fas fa-user-crown</v-icon>
										</template>
									</v-text-field>
								</v-col>

								<!-- Organized Date -->
								<v-col cols="12" sm="6" md="6">
									<v-dialog
										v-model="modalOrganizedDate"
										:scrollable="false"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="department.organized_date"
												:label="$t('DEPARTMENT_MANAGEMENT.ORGANIZED_DATE')"
												readonly
												solo
												v-bind="attrs"
												v-on="on"
											>
												<template #prepend-inner>
													<v-icon small :color="prependIconColor">fas fa-calendar</v-icon>
												</template>
											</v-text-field>
										</template>

										<v-date-picker
											v-model="department.organized_date"
											show-current
											:locale="language"
											elevation="24"
											color="green lighten-1"
											@input="modalOrganizedDate = false"
										/>
									</v-dialog>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="12">
									<v-btn class="primary-btn float-right ml-3" @click="doRegister()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>Register</span>
									</v-btn>

									<v-btn class="danger-btn float-right" @click="registerDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>Cancel</span>
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
import vHeaderPage from '@/components/atoms/vHeaderPage';

export default {
    name: 'DepartmentManagementList',
    components: {
        vHeaderPage,
    },
    data() {
        return {
            DepartmentList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            department: {
                name: '',
                address: '',
                manager: '',
                organized_date: '',
            },

            modalOrganizedDate: false,

            headers: [
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_NAME') + ' ⇅', sortable: true, value: 'department_name' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_ADDRESS'), sortable: false, value: 'department_address' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.TOTAL_STAFF') + ' ⇅', sortable: true, value: 'total_staff' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_MANAGER'), sortable: false, value: 'department_manager' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.ORGANIZED_DATE') + ' ⇅', sortable: true, value: 'organized_date' },
            ],

            items: [
                {
                    department_id: 1,
                    department_name: 'Ban Lễ Tân',
                    department_address: 'Toà A, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Nguyễn Văn Cừ',
                    organized_date: '2020-01-01',
                },
                {
                    department_id: 2,
                    department_name: 'Ban Vệ Sinh',
                    department_address: 'Toà B, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Nguyễn Bảo Linh',
                    organized_date: '2020-01-01',
                },
                {
                    department_id: 3,
                    department_name: 'Ban Quản Lý',
                    department_address: 'Toà C, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Trần Thị Hồng Linh',
                    organized_date: '2020-01-01',
                },
                {
                    department_id: 4,
                    department_name: 'Ban Dịch Vụ',
                    department_address: 'Toà D, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Vũ Thu Thuỷ',
                    organized_date: '2020-01-01',
                },
                {
                    department_id: 5,
                    department_name: 'Ban Kỹ Thuật',
                    department_address: 'Toà E, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Nguyễn Thanh Hoàn',
                    organized_date: '2020-01-01',
                },
                {
                    department_id: 6,
                    department_name: 'Ban An Ninh',
                    department_address: 'Toà F, Tầng 1',
                    total_staff: 15,
                    department_manager: 'Nguyễn Văn Cừ',
                    organized_date: '2020-01-01',
                },
            ],

            prependIconColor: '#1E2A55',

            registerDialog: false,

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getDepartmentList();
    },
    methods: {
        getDepartmentList() {
            console.log('Get Department List');
        },

        doRegister() {
            console.log('Do Register');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .department-management {
    max-height: 768px;

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .department-management-list-table {
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
    .department-management {
      max-height: 100%;
    }
  }
</style>
