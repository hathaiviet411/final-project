<template>
	<b-button
		:class="className"
		:disabled="disabled"
	>
		<slot>{{ textButton }}</slot>
	</b-button>
</template>

<script>
export default {
    name: 'VButton',
    props: {
        textButton: {
            type: String,
            require: true,
            default: 'Button',
        },
        className: {
            type: String,
            require: false,
            default: 'v-button-default',
        },
        disabled: {
            type: Boolean,
            require: false,
            default: false,
        },
    },
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables.scss';

    .btn {
        min-width: 150px;
        border: none;
    }

    .login-btn {
        min-width: 250px;
        border-radius: 0.25rem;
    }

    .maintenance-pdf-btn {
        min-width: 200px;
        float: right;
        margin-bottom: 10px;
        margin-top: 30px;
        text-align: center;
        align-items: center;
        background-color: $cloud-burst;
    }

    .maintenance-btn {
        width: 100%;
        height: 48px;
        font-weight: bold;
    }

    .maintenance-btn-default {
        &:hover {
            opacity: .5;
            background-color: $cloud-burst !important;
        }

        &:active {
            background-color: $cloud-burst !important;
        }

        &:focus {
            background-color: $cloud-burst !important;
        }
    }

    .vehicle-info-btn {
        width: 100%;
        height: 48px;
        font-weight: bold;
    }

    .cost-info-btn {
        width: 100%;
        height: 48px;
        font-weight: bold;
    }

    .updated-history-btn {
        width: 100%;
        height: 48px;
        font-weight: bold;
    }

    .vehicle-info-btn-default {
        &:hover {
            opacity: .5;
            background-color: $cloud-burst !important;
        }

        &:active {
            background-color: $cloud-burst !important;
        }

        &:focus {
            background-color: $cloud-burst !important;
        }
    }

    .v-button-default {
        background-color: $cloud-burst !important;
        font-weight: bold;
        color: $white;

        &:hover {
            opacity: .5;
            background-color: $cloud-burst !important;
        }

        &:active {
            background-color: $cloud-burst !important;
        }

        &:focus {
            background-color: $cloud-burst !important;
        }
    }

    .v-button-primary {
        background-color: $cloud-burst !important;

        &:hover {
            opacity: .5;
            background-color: $cloud-burst !important;
        }

        &:active {
            background-color: $cloud-burst !important;
        }

        &:focus {
            background-color: $cloud-burst !important;
        }
    }
</style>
