<template>
	<div class="date-selector">
		<b-button-group>
			<b-button class="minus-btn" @click="minus()">
				<i class="fas fa-caret-left" />
			</b-button>
			<b-button class="date">
				{{ date }}
			</b-button>
			<b-button class="plus-btn" @click="plus()">
				<i class="fas fa-caret-right" />
			</b-button>
		</b-button-group>
	</div>
</template>

<script>
const d = new Date();
const YEAR = d.getFullYear();
const MONTH = d.getMonth() + 1;

export default {
    name: 'DateSelector',
    data() {
        return {
            year: YEAR,
            month: MONTH,
        };
    },
    computed: {
        date() {
            return this.dateMonth(this.year, this.month);
        },
    },
    methods: {
        dateMonth(year, month) {
            if (this.validateYear(year) === false) {
                return '';
            }

            if (this.validateMonth(month) === false) {
                return '';
            }

            return this.formatYearMonth(year, month);
        },
        validateYear(year) {
            const re = /^[1-9]\d{3,}$/;

            return re.test(year);
        },
        validateMonth(month) {
            if (month >= 1 && month <= 12) {
                return true;
            }

            return false;
        },
        formatYearMonth(year, month) {
            if (month >= 1 && month <= 9) {
                month = '0' + month;
            }

            return `${year}-${month}`;
        },

        minus() {
            if (this.month > 1) {
                this.month = this.month - 1;
            } else if (this.month === 1) {
                this.month = 12;
                this.year = this.year - 1;
            }
        },
        plus() {
            if (this.month < 12) {
                this.month = this.month + 1;
            } else if (this.month === 12) {
                this.month = 1;
                this.year = this.year + 1;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
@import '@/scss/variables';

.date-selector {
    button {
        background-color: $cloud-burst;
        color: $white;

        &:active {
            background-color: $cloud-burst;
        }

        &:focus {
            background-color: $cloud-burst;
        }
    }

    button.date {
        cursor: default;
        min-width: 120px;
        font-weight: 600;
    }

    button.minus-btn,
    button.plus-btn {
        &:hover {
            opacity: .8 !important;
            background-color: $cloud-burst;
            color: $white;
        }
    }
}
</style>
