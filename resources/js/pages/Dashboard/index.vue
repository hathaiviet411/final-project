<template>
	<div class="dashboard">
		<v-app>
			<v-row>
				<v-col cols="12">
					<v-card elevation="12">
						<v-img :src="require('@/assets/images/footer.png')" />
					</v-card>
				</v-col>
			</v-row>

			<v-row>
				<v-col cols="3" class="text-center">
					<v-btn class="primary-btn">
						<v-icon small class="mr-3">fas fa-building</v-icon>
						<span>Total Department: 14</span>
					</v-btn>
				</v-col>

				<v-col cols="3" class="text-center">
					<v-btn class="primary-btn">
						<v-icon small class="mr-3">fas fa-user</v-icon>
						<span>Total Staff: 2123</span>
					</v-btn>
				</v-col>

				<v-col cols="3" class="text-center">
					<v-btn class="primary-btn">
						<v-icon small class="mr-3">fas fa-tasks</v-icon>
						<span>Total Task: 56112</span>
					</v-btn>
				</v-col>

				<v-col cols="3" class="text-center">
					<v-btn class="primary-btn">
						<v-icon small class="mr-3">fas fa-comment-alt</v-icon>
						<span>Total Feedback: 4129</span>
					</v-btn>
				</v-col>
			</v-row>

			<v-row class="mb-3" style="height: 800px">
				<v-col cols="10">
					<v-row>
						<v-col cols="6">
							<v-card elevation="12" style="padding: 15px !important;" rounded="lg" height="690">
								<Bar
									:chart-options="chartOptions"
									:chart-data="chartOneData"
								/>
							</v-card>
						</v-col>

						<v-col cols="6">
							<v-card elevation="12" style="padding: 30px !important;" rounded="lg" height="690">
								<Bar
									:chart-options="chartOptions"
									:chart-data="chartTwoData"
								/>
							</v-card>
						</v-col>
					</v-row>
				</v-col>

				<v-col cols="2">
					<v-card elevation="12" class="mx-auto py-2 px-2" height="690">
						<v-img :src="link" class="mx-auto" height="670" />
					</v-card>
				</v-col>
			</v-row>
		</v-app>
	</div>
</template>

<script>
import { Bar } from 'vue-chartjs/legacy';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
    name: 'DashboardIndex',
    components: {
        Bar,
    },
    data() {
        return {
            img_link: '',
            isMobileMode: false,

            chartOneData: {
                labels: [
                    'Ban Tổ Chức',
                    'Ban An Ninh',
                    'Ban Lễ Tân',
                    'Ban Vệ Sinh',
                    'Ban Kỹ Thuật',
                    'Ban Quản Lý',
                    'Ban Dịch Vụ',
                ],
                datasets: [{
                    label: 'Xếp hạng phòng ban',
                    data: [1, 4, 3, 6, 2, 5, 7],
                    backgroundColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderWidth: 1,
                }],
            },

            chartTwoData: {
                labels: [
                    'Nguyễn Văn C',
                    'NGuyễn Văn D',
                    'Trần Thanh P',
                    'Hạ Thanh N',
                    'Dương Minh A',
                    'Hoàng Tranh T',
                    'Trịnh Công M',
                ],
                datasets: [{
                    label: 'Xếp hạng nhân viên',
                    data: [4, 1, 3, 2, 5, 6, 7],
                    backgroundColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderWidth: 1,
                }],
            },

            chartOptions: {
                responsive: true,
            },
        };
    },
    created() {
        window.addEventListener('resize', this.handleResizeResolution);
        this.handleResizeResolution();
        this.randomSideImage();
    },
    destroyed() {
        window.removeEventListener('resize', this.handleResizeResolution);
    },
    methods: {
        randomSideImage() {
            this.link = require('@/assets/images/art' + Math.floor((Math.random() * 12) + 1) + '.png');
        },

        handleResizeResolution() {
            var clientWidth = window.innerWidth;

            if (clientWidth <= 768) {
                this.isMobileMode = true;
            } else {
                this.isMobileMode = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import '@/scss/variables.scss';
</style>
