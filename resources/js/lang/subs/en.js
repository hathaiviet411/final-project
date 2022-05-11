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

    PAGE404: {
        OOPS: 'Oops!',
        MESSAGE: `The bodyguard said that you can't enter this page...`,
        DETAIL: 'Please check that the URL you entered is correct. Please click the button below to return to the homepage or send an error report.',
        BACK_TO_HOME: 'Back to Home',
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

            ROOM_MANAGEMENT: {
                CREATE_ROOM_SUCCESS: 'Create room successfully.',
                CREATE_ROOM_FAILED: 'Create room failed.',
                UPDATE_ROOM_SUCCESS: 'Update room successfully.',
                UPDATE_ROOM_FAILED: 'Update room failed.',
                DELETE_ROOM_SUCCESS: 'Delete room successfully.',
                DELETE_ROOM_FAILED: 'Delete room failed.',
            },

            FEEDBACK_MANAGEMENT: {
                CREATE_FEEDBACK_SUCCESS: 'Create feedback successfully.',
                CREATE_FEEDBACK_FAILED: 'Create feedback failed.',
                UPDATE_FEEDBACK_SUCCESS: 'Update feedback successfully.',
                UPDATE_FEEDBACK_FAILED: 'Update feedback failed.',
                DELETE_FEEDBACK_SUCCESS: 'Delete feedback successfully.',
                DELETE_FEEDBACK_FAILED: 'Delete feedback failed.',
            },

            FACILITY_MANAGEMENT: {
                CREATE_FACILITY_SUCCESS: 'Create facility successfully.',
                CREATE_FACILITY_FAILED: 'Create facility failed.',
                UPDATE_FACILITY_SUCCESS: 'Update facility successfully.',
                UPDATE_FACILITY_FAILED: 'Update facility failed.',
                DELETE_FACILITY_SUCCESS: 'Delete facility successfully.',
                DELETE_FACILITY_FAILED: 'Delete facility failed.',
            },

            STAFF_MANAGEMENT: {
                CREATE_STAFF_SUCCESS: 'Create staff successfully.',
                CREATE_STAFF_FAILED: 'Create staff failed.',
                UPDATE_STAFF_SUCCESS: 'Update staff successfully.',
                UPDATE_STAFF_FAILED: 'Update staff failed.',
                DELETE_STAFF_SUCCESS: 'Delete staff successfully.',
                DELETE_STAFF_FAILED: 'Delete staff failed.',
            },

            SCHEDULE_MANAGEMENT: {
                UPDATE_SCHEDULE_SUCCESS: 'Update schedule successfully.',
                UPDATE_SCHEDULE_FAILED: 'Update schedule failed.',
                REQUIRED_TASK_NAME: 'Please select task name.',
                REQUIRED_START_DATE: 'Please enter start date.',
                REQUIRED_START_TIME: 'Please enter start time.',
                REQUIRED_END_TIME: 'Please enter end time.',
                REQUIRED_BUILDING: 'Please select building.',
                REQUIRED_ROOM: 'Please select room.',
                ADD_NEW_TASK_SUCCESS: 'Add new task successfully.',
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

    TIMESHEET_MANAGEMENT: {
        DETAIL_TIMESHEET: 'Detail Timesheet',
    },

    SCHEDULE_MANAGEMENT: {
        DEPARTMENT: 'Department',
        USER_NAME: 'User Name',
        POSITION: 'Position',
        ROLE: 'Role',
        CONTRACT_TYPE: 'Contract Type',
        BUILDING: 'Building',
        LEVEL: 'Level',
        ROOM: 'Room',
        START_TIME: 'Start Time',
        END_TIME: 'End Time',
        NEW_SCHEDULE: 'New Schedule',
        DETAIL_SCHEDULE: 'Detail Schedule',
        USER_INFORMATION: 'User Information',
        WORKING_PLACE_INFORMATION: 'Working Place Information',
        WORKING_TIME_INFORMATION: 'Working Time Information',
        TASK_INFORMATION: 'Task Information',
        LOG_TIME: 'Log Time',
        APPROVE_STATUS: {
            TITLE: 'Approve Status',
            APPROVED: 'Approved',
            REFUSED: 'Refused',
        },
        REMARK: 'Remark',
        TASK_STATUS: {
            TITLE: 'Task Status',
            PENDING: 'Pending',
            IN_PROGRESS: 'In Progress',
            COMPLETED: 'Completed',
            FEEDBACK: 'Feedback',
            ABORTED: 'Aborted',
        },
        SPENT_TIME: 'Spent Time',
        ESTIMATE_TIME: 'Estimate Time',
        LIST_ASSIGNED_TASK: 'List Assigned Task',
        DATE: 'Start Date',
        HOUR: 'Hour',
        HOURS: 'Hours',
        MINUTE: 'Minute',
        MINUTES: 'Minutes',
        INVALID_TIME: 'Invalid time',
        FILTER: {
            DEPARTMENT: 'Department',
            POSITION: 'Position',
            CONTRACT_TYPE: 'Contract Type',
        },
        ASSIGN_STATUS: {
            TITLE: 'Status',
            ASSIGNED: 'Assigned',
            UNASSIGNED: 'Unassigned',
        },
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
        USER_NAME: 'User Name',
        USER_CODE: 'User Code',
        PASSWORD: 'Password',
        EMAIL: 'Email',
        DOB: 'Date of Birth',
        PARTICIPATED_DATE: 'Participated Date',
        ADDRESS: 'Address',
        PHONE_NUMBER: 'Phone Number',
        IS_RETIRED: {
            TITLE: 'Is Retired',
            RETIRED: 'Retired',
            WORKING: 'Working',
        },
        AVATAR: 'Avatar',
        ROLE: 'Role',
        DEPARTMENT: 'Department',
        POSITION: 'Position',
        CONTRACT: 'Contract',
        NEW_STAFF: 'New Staff',
        DETAIL_STAFF: 'Detail Staff',
        EDIT_STAFF: 'Edit Staff',
        DELETE_STAFF: 'Delete Staff',
        EMAIL_FORMAT_ERROR: 'Email format is not correct.',
    },

    POSITION: {
        GENERAL_MANAGER: 'General Manager',
        DEPUTY_GENERAL_MANAGER: 'Deputy General Manager',
        ROOMS_DIVISION_MANAGER: 'Rooms Division Manager',
        FRONT_DESK_MANAGER: 'Front Desk Manager',
        HOUSEKEEPING_MANAGER: 'Housekeeping Manager',
        FB_MANAGER: 'F&B Manager',
        SALES_MARKETING_MANAGER: 'Sales & Marketing Manager',
        ACCOUNTING_MANAGER: 'Accounting Manager',
        HR_MANAGER: 'HR Manager',
        ADMINISTRATION_MANAGER: 'Administration Manager',
        ENGINEERING_MANAGER: 'Engineering Manager',
        RECEPTIONIST: 'Receptionist',
        RESERVATION: 'Reservation',
        CASHIER: 'Cashier',
        CONCIERGE: 'Concierge',
        BELLMAN: 'Bellman',
        DOORMAN: 'Doorman',
        HOUSEKEEPING: 'Housekeeping',
        LAUNDRY: 'Laundry',
        LINEN_ROOM: 'Linen Room',
        GARDENER: 'Gardener',
        PEST_CONTROL: 'Pest Control',
        PUBLIC_AREA_CLEANER: 'Public Area Cleaner',
        BABY_SITTER: 'Baby Sitter',
        LOCKER_ATTENDANT: 'Locker Attendant',
        CHEF: 'Chef',
        COOK_ASSISTANT: 'Cook Assistant',
        BAKERY: 'Bakery',
        STEWARD: 'Steward',
        WAITRESS: 'Waitress',
        HOSTESS: 'Hostess',
        ORDER_TAKER: 'Order Taker',
        FOOD_RUNNER: 'Food Runner',
        EVENT_STAFF: 'Event Staff',
        BARTENDER: 'Bartender',
        BARISTA: 'Barista',
        MARKETING: 'Marketing',
        PR: 'PR',
        SALES_CORP: 'Sales Corp',
        SALES_TOUR: 'Sales Tour',
        SALES_ONLINE: 'Sales Online',
        GENERAL_ACCOUNTANT: 'General Accountant',
        DEBT_ACCOUNTANT: 'Debt Accountant',
        AUDITOR: 'Auditor',
        CASH_KEEPER: 'Cash Keeper',
        PURCHASER: 'Purchaser',
        PAYROLL: 'Payroll',
        INSURANCE: 'Insurance',
        LEGAL_OFFICER: 'Legal Officer',
        ELECTRICAL_ENGINEER: 'Electrical Engineer',
        PLUMBER: 'Plumber',
        CARPENTER: 'Carpenter',
        PAINTER: 'Painter',
        AC_CHILLER: 'AC Chiller',
        BOILER: 'Boiler',
        IT_MAN: 'IT Man',
        RESCUER: 'Rescuer',
        SECURITY: 'Security',
        STORE_KEEPER: 'Store Keeper',
    },

    CONTRACT: {
        FULL_TIME: 'Full Time',
        PART_TIME: 'Part Time',
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
        EDIT_ROOM: 'Edit Room',
        DELETE_ROOM: 'Delete Room',
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
        FACILITY_TITLE: 'Facility Title',
        FACILITY_DETAIL: 'Facility Detail',
        START_DATE: 'Start Maintenance',
        END_DATE: 'End Maintenance Date',
        RESPONSIBLE_STAFF: 'Responsible Staff',
        STATUS: {
            TITLE: 'Status',
            PENDING: 'Pending',
            MAINTAINING: 'Maintaining',
            FINISHED: 'Finished',
        },
        NEW_FACILITY: 'New Maintenance',
        EDIT_FACILITY: 'Edit Maintenance',
        DELETE_FACILITY: 'Delete Maintenance',
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

    ROLE: {
        ADMIN: 'Admin',
        MANAGER: 'Manager',
        STAFF: 'Staff',
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
        ASSIGN_TASK: 'Assign Task',
        REMOVE_TASK: 'Remove Task',
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
