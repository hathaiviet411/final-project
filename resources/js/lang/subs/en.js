export default {
    ROUTER: {
        DASHBOARD: 'Dashboard',
        STAFF_MANAGEMENT: 'Staff Management',
        SCHEDULE_MANAGEMENT: 'Schedule Management',
        FACILITY_MAINTENANCE: 'Facility Maintenance',
        ROOM_MANAGEMENT: 'Room Management',
        TASK_MANAGEMENT: 'Task Management',
        TIMESHEET: 'Timesheet',
        DEPARTMENT_MANAGEMENT: 'Department Management',
        FEEDBACK_MANAGEMENT: 'Feedback Management',
        DEV: 'Dev',
    },

    TOAST: {
        TITLE: {
            SUCCESS: 'Success',
            WARNING: 'Warning',
            ERROR: 'Error',
        },

        CONTENT: {
            LOGIN: {
                SUCCESS: 'Logged in successfully.',
                WRONG_ID_PASSWORD: 'You entered the wrong format of ID, Password.',
                REQUIRE_USER_ID: 'Please enter User ID',
                REQUIRE_PASSWORD: 'Please enter Password',
            },

            DEPARTMENT_MANAGEMENT: {
                CREATE_DEPARTMENT_SUCCESS: 'Create department successfully.',
                CREATE_DEPARTMENT_FAILED: 'Create department failed.',
                UPDATE_DEPARTMENT_SUCCESS: 'Update department successfully.',
                UPDATE_DEPARTMENT_FAILED: 'Update department failed.',
                DELETE_DEPARTMENT_SUCCESS: 'Delete department successfully.',
                DELETE_DEPARTMENT_FAILED: 'Delete department failed.',
            },

            TASK_MANAGEMENT: {
                CREATE_TASK_SUCCESS: 'Create task successfully.',
                CREATE_TASK_FAILED: 'Create task failed.',
                UPDATE_TASK_SUCCESS: 'Update task successfully.',
                UPDATE_TASK_FAILED: 'Update task failed.',
                DELETE_TASK_SUCCESS: 'Delete task successfully.',
                DELETE_TASK_FAILED: 'Delete task failed.',
            },

            FEEDBACK_MANAGEMENT: {
                CREATE_FEEDBACK_SUCCESS: 'Create feedback successfully.',
                CREATE_FEEDBACK_FAILED: 'Create feedback failed.',
                UPDATE_FEEDBACK_SUCCESS: 'Update feedback successfully.',
                UPDATE_FEEDBACK_FAILED: 'Update feedback failed.',
                DELETE_FEEDBACK_SUCCESS: 'Delete feedback successfully.',
                DELETE_FEEDBACK_FAILED: 'Delete feedback failed.',
            },

            LOGOUT: {
                SUCCESS: 'You have successfully logged out.',
            },

            OTHER: {
                ERROR: 'An unexpected error has occurred',
            },
        },

        I18N: {
            CHANGE_LANGUAGE: {
                SUCCESS: 'Change language successfully.',
                FAILED: 'Language change failed.',
            },
        },
    },

    LOGIN: {
        ID: 'User ID',
        PASSWORD: 'Password',
        BUTTON_TEXT: 'Login',
    },

    SCHEDULE_MANAGEMENT: {
        DEPARTMENT: 'Department',
        USER_NAME: 'User Name',
        POSITION: 'Position',
        CONTRACT_TYPE: 'Contract Type',
    },

    DEPARTMENT_MANAGEMENT: {
        DEPARTMENT_NAME: 'Department Name',
        DEPARTMENT_ADDRESS: 'Department Address',
        TOTAL_STAFF: 'Total Staff',
        DEPARTMENT_MANAGER: 'Department Manager',
        ORGANIZED_DATE: 'Organized Date',
        NEW_DEPARTMENT: 'New Department',
        EDIT_DEPARTMENT: 'Edit Department',
        DELETE_DEPARTMENT: 'Delete Department',
    },

    STAFF_MANAGEMENT: {
        STAFF_CODE: 'User Code',
        FULL_NAME: 'Full Name',
        EMAIL: 'Email',
        DOB: 'Date of Birth',
        ADDRESS: 'Address',
        PARTICIPATED_DATE: 'Participated Date',
        DEPARTMENT: 'Department',
        ROLE: 'Role',
        POSITION: 'Position',
        CONTRACT_TYPE: 'Contract Type',
        PHONE_NUMBER: 'Phone Number',
        IS_RETIRED: 'Is Retired',
        NEW_STAFF: 'New Staff',
    },

    ROOM_MANAGEMENT: {
        ROOM_NUMBER: 'Room Number',
        ROOM_TYPE: 'Room Type',
        ROOM_CAPACITY: 'Room Capacity',
        ROOM_STATUS: 'Room Status',
        LEVEL: 'Level',
        ROOM_INFORMATION: 'Room Information',
        BUILDING: 'Building',
        NEW_ROOM: 'New Room',
    },

    TASK_MANAGEMENT: {
        TASK_NAME: 'Task Name',
        TASK_DESCRIPTION: 'Task Description',
        REQUIRED_POSITION: 'Required Position',
        REQUIRED_CONTRACT_TYPE: 'Required Contract Type',
        NEW_TASK: 'New Task',
        EDIT_TASK: 'Edit Task',
        DELETE_TASK: 'Delete Task',
    },

    FACILITY_MAINTENANCE: {
        FACILITY_NAME: 'Facility Name',
        DESCRIPTION: 'Description',
        STATUS: 'Facility Status',
        MAINTAINED_START_DATE: 'Maintained Start Date',
        RESPONSIBLE_STAFF: 'Responsible Staff',
        NEW_FACILITY: 'New Issue',
    },

    FEEDBACK_MANAGEMENT: {
        FEEDBACK_TITLE: 'Feedback Title',
        FEEDBACK_CONTENT: 'Feedback Content',
        UPLOADED_DATE: 'Uploaded Date',
        SUBJECT: 'Subject',
        USER_NAME: 'User Name',
        DEPARTMENT: 'Department',
        POSITION: 'Position',
        STATUS: {
            STATUS: 'Status',
            PENDING: 'Pending',
            PROCESSING: 'Processing',
            CLOSED: 'Closed',
            CANCELED: 'Canceled',
        },
        NEW_FEEDBACK: 'New Feedback',
        EDIT_FEEDBACK: 'Edit Feedback',
        DELETE_FEEDBACK: 'Delete Feedback',
    },

    PAGE_TITLE: {
        STAFF_MANAGEMENT: 'Staff Management',
        FACILITY_MANAGEMENT: 'Facility Management',
        TIMESHEET: 'Timesheet',
        DEPARTMENT_MANAGEMENT: 'Department Management',
        DEV: 'Dev',
    },

    BUTTON: {
        PDF: 'PDF',
        REGISTER: 'Register',
        CLEAR_ALL: 'Clear All',
        APPLY: 'Apply',
        DETAIL: 'Detail',
        DELETE: 'Delete',
        BACK: 'Back',
        SAVE: 'Save',
        EDIT: 'Edit',
        MONTH_YEAR: 'Month Year',
        DEPARTMENT: 'Department',
        SEARCH: 'Search',
        SORT_BY: 'Sort By',
        ACTIONS: 'Actions',
        CANCEL: 'Cancel',
        SCHEDULE_DETAIL: 'Schedule Detail',
        ASSIGN_NEW_TASK: 'Assign New Task',
    },

    FILTER: {
        TITLE: 'Filter',
        NO_DATE_SELECTED: 'No date selected',
        DATE_PICKER_LABEL_HELP: 'Use cursor keys to navigate calendar dates',
    },

    TABLE: {
        EMPTY: 'No data',
        NOT_COMPLETED: 'Not Completed',
        COMPLETED: 'Completed',
    },

    MODAL: {
        DELETE_CONFIRMATION: 'Are you sure to delete ?',
        YES: 'Yes',
        NO: 'No',
    },

    OVERLAY: {
        PLEASE_WAIT: 'Please Wait',
    },

    PLACE_HOLDER: {
        PLEASE_SELECT: '-- Please Select --',
        USER_ROLE: 'Please Select User Role',
        DEPARTMENT: 'Please Select Department',
        USER_ID: 'Please Enter User ID',
        USER_NAME: 'Please Enter User Name',
        PWD: 'Please Enter Password',
        NEW_PWD: 'Please Enter New Password',
    },

    DATE: {
        YEAR: 'Year',
        MONTH: 'Month',
        DAY: 'Day',
    },

    NAVBAR: {
        LOGOUT: 'Logout',
    },

    DEV: {
        LANGUAGE: 'Language',
        ENGLISH: 'English',
        VIETNAMESE: 'Vietnamese',
    },

    SPECIAL_CHARACTER: {
        DASH_ARROW: '➟',
    },

    PAGINATION: {
        DISPLAY_PER_PAGE: 'Per Page',
        ALL: 'All',
    },

    TEXT_COLLAPSE: 'Collapse',
};
