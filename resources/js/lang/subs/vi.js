export default {
    ROUTER: {
        DASHBOARD: 'Trang chủ',
        STAFF_MANAGEMENT: 'Quản lý nhân viên',
        SCHEDULE_MANAGEMENT: 'Thời khoá biểu',
        FACILITY_MAINTENANCE: 'Bảo trì cơ sở vật chất',
        ROOM_MANAGEMENT: 'Quản lý phòng ở',
        TASK_MANAGEMENT: 'Quản lý tác vụ',
        TIMESHEET: 'Quản lý chấm công',
        DEPARTMENT_MANAGEMENT: 'Quản lý phòng ban',
        FEEDBACK_MANAGEMENT: 'Quản lý phản hồi',
        DEV: 'Phát triển',
    },

    TOAST: {
        TITLE: {
            SUCCESS: 'Thành công',
            WARNING: 'Cảnh báo',
            ERROR: 'Thất bại',
        },

        CONTENT: {
            LOGIN: {
                SUCCESS: 'Đăng nhập thành công',
                WRONG_ID_PASSWORD: 'Tài khoản hoặc mật khẩu không chính xác.',
                REQUIRE_USER_ID: 'Vui lòng nhập tài khoản',
                REQUIRE_PASSWORD: 'Vui lòng nhập mật khẩu',
            },

            DEPARTMENT_MANAGEMENT: {
                CREATE_DEPARTMENT_SUCCESS: 'Tạo phòng ban thành công.',
                CREATE_DEPARTMENT_FAILED: 'Tạo phòng ban thất bại.',
                UPDATE_DEPARTMENT_SUCCESS: 'Cập nhật phòng ban thành công.',
                UPDATE_DEPARTMENT_FAILED: 'Cập nhật phòng ban thất bại.',
                DELETE_DEPARTMENT_SUCCESS: 'Xóa phòng ban thành công.',
                DELETE_DEPARTMENT_FAILED: 'Xóa phòng ban thất bại.',
            },

            TASK_MANAGEMENT: {
                CREATE_TASK_SUCCESS: 'Tạo công việc thành công.',
                CREATE_TASK_FAILED: 'Tạo công việc thất bại.',
                UPDATE_TASK_SUCCESS: 'Cập nhật công việc thành công.',
                UPDATE_TASK_FAILED: 'Cập nhật công việc thất bại.',
                DELETE_TASK_SUCCESS: 'Xóa công việc thành công.',
                DELETE_TASK_FAILED: 'Xóa công việc thất bại.',
            },

            FEEDBACK_MANAGEMENT: {
                CREATE_FEEDBACK_SUCCESS: 'Tạo phản hồi thành công.',
                CREATE_FEEDBACK_FAILED: 'Tạo phản hồi thất bại.',
                UPDATE_FEEDBACK_SUCCESS: 'Cập nhật phản hồi thành công.',
                UPDATE_FEEDBACK_FAILED: 'Cập nhật phản hồi thất bại.',
                DELETE_FEEDBACK_SUCCESS: 'Xóa phản hồi thành công.',
                DELETE_FEEDBACK_FAILED: 'Xóa phản hồi thất bại.',
            },

            LOGOUT: {
                SUCCESS: 'Đăng xuất thành công',
            },

            OTHER: {
                ERROR: 'Có lỗi xảy ra',
            },
        },

        I18N: {
            CHANGE_LANGUAGE: {
                SUCCESS: 'Thay đổi ngôn ngữ thành công.',
                FAILED: 'Thay đổi ngôn ngữ thất bại.',
            },
        },
    },

    LOGIN: {
        ID: 'Tài khoản',
        PASSWORD: 'Mật khẩu',
        BUTTON_TEXT: 'Đăng nhập',
    },

    SCHEDULE_MANAGEMENT: {
        DEPARTMENT: 'Phòng ban',
        USER_NAME: 'Tên nhân viên',
        POSITION: 'Chức vụ',
        CONTRACT_TYPE: 'Loại hợp đồng',
    },

    DEPARTMENT_MANAGEMENT: {
        DEPARTMENT_NAME: 'Tên phòng ban',
        DEPARTMENT_ADDRESS: 'Địa chỉ phòng ban',
        TOTAL_STAFF: 'Tổng số nhân viên',
        DEPARTMENT_MANAGER: 'Quản lý',
        ORGANIZED_DATE: 'Ngày thành lập',
        NEW_DEPARTMENT: 'Thêm phòng ban mới',
        EDIT_DEPARTMENT: 'Chỉnh sửa thông tin phòng ban',
        DELETE_DEPARTMENT: 'Xoá phòng ban',
    },

    STAFF_MANAGEMENT: {
        STAFF_CODE: 'Mã nhân viên',
        FULL_NAME: 'Họ và tên',
        EMAIL: 'Email',
        DOB: 'Ngày sinh',
        PARTICIPATED_DATE: 'Ngày gia nhập',
        DEPARTMENT: 'Phòng ban',
        ROLE: 'Vai trò',
        POSITION: 'Chức vụ',
        CONTRACT_TYPE: 'Loại hợp đồng',
        ADDRESS: 'Địa chỉ',
        PHONE_NUMBER: 'Số điện thoại',
        IS_RETIRED: 'Trạng thái',
        NEW_STAFF: 'Thêm nhân viên mới',
    },

    POSITION: {
        GENERAL_MANAGER: 'Tổng giám đốc',
        DEPUTY_GENERAL_MANAGER: 'Phó Tổng giám đốc',
        ROOMS_DIVISION_MANAGER: 'Quản lý bộ phận phòng khách',
        FRONT_DESK_MANAGER: 'Quản lý bộ phận lễ tân',
        HOUSEKEEPING_MANAGER: 'Quản lý buồng',
        FB_MANAGER: 'Quản lý bộ phận ẩm thực',
        SALES_MARKETING_MANAGER: 'Quản lý kinh doanh',
        ACCOUNTING_MANAGER: 'Quản lý tài chính, kế toán',
        HR_MANAGER: 'Quản lý bộ phận nhân sự',
        ADMINISTRATION_MANAGER: 'Quản lý bộ phận hành chính',
        ENGINEERING_MANAGER: 'Quản lý bộ phận kỹ thuật',
        RECEPTIONIST: 'Nhân viên lễ tân',
        RESERVATION: 'Nhân viên đặt phòng',
        CASHIER: 'Nhân viên thu ngân',
        CONCIERGE: 'Nhân viên hỗ trợ khách hàng',
        BELLMAN: 'Nhân viên hành lý',
        DOORMAN: 'Nhân viên đứng cửa',
        HOUSEKEEPING: 'Nhân viên làm phòng',
        LAUNDRY: 'Nhân viên giặt là',
        LINEN_ROOM: 'Nhân viên kho vải',
        GARDENER: 'Nhân viên làm vườn',
        PEST_CONTROL: 'Nhân viên diệt côn trùng',
        PUBLIC_AREA_CLEANER: 'Nhân viên vệ sinh công cộng',
        BABY_SITTER: 'Nhân viên trông trẻ',
        LOCKER_ATTENDANT: 'Nhân viên phòng thay đồ',
        CHEF: 'Bếp trưởng',
        COOK_ASSISTANT: 'Phụ bếp',
        BAKERY: 'Nhân viên bếp bánh',
        STEWARD: 'Nhân viên rửa bát',
        WAITRESS: 'Nhân viên phục vụ',
        HOSTESS: 'Nhân viên đứng cửa',
        ORDER_TAKER: 'Nhân viên điểm món',
        FOOD_RUNNER: 'Nhân viên chạy món',
        EVENT_STAFF: 'Nhân viên tiệc',
        BARTENDER: 'Nhân viên pha chế rượu, cocktail',
        BARISTA: 'Nhân viên pha chế cà phê',
        MARKETING: 'Nhân viên Marketing',
        PR: 'Nhân viên PR/ Quan hệ khách hàng',
        SALES_CORP: 'Nhân viên sales khách công ty',
        SALES_TOUR: 'Nhân viên sales khách tour',
        SALES_ONLINE: 'Nhân viên sales trên Internet',
        GENERAL_ACCOUNTANT: 'Nhân viên kế toán tổng hợp',
        DEBT_ACCOUNTANT: 'Nhân viên kế toán công nợ',
        AUDITOR: 'Nhân viên kế toán nội bộ',
        CASH_KEEPER: 'Nhân viên thủ quỹ',
        PURCHASER: 'Nhân viên thu mua',
        PAYROLL: 'Nhân viên lương',
        INSURANCE: 'Nhân viên bảo hiểm',
        LEGAL_OFFICER: 'Nhân viên pháp lý',
        ELECTRICAL_ENGINEER: 'Nhân viên điện',
        PLUMBER: 'Nhân viên nước',
        CARPENTER: 'Nhân viên mộc',
        PAINTER: 'Nhân viên sơn',
        AC_CHILLER: 'Nhân viên điện lạnh',
        BOILER: 'Nhân viên nồi hơi',
        IT_MAN: 'Nhân viên IT',
        RESCUER: 'Nhân viên cứu hộ',
        SECURITY: 'Nhân viên bảo vệ',
        STORE_KEEPER: 'Nhân viên thủ kho',
    },

    CONTRACT: {
        FULL_TIME: 'Toàn thời gian',
        PART_TIME: 'Bán thời gian',
    },

    ROOM_MANAGEMENT: {
        ROOM_NUMBER: 'Sô phòng',
        ROOM_TYPE: 'Loại phòng',
        ROOM_CAPACITY: 'Sức chứa',
        ROOM_STATUS: 'Trạng thái',
        LEVEL: 'Tầng',
        ROOM_INFORMATION: 'Thông tin phòng',
        BUILDING: 'Toà',
        NEW_ROOM: 'Thêm phòng mới',
    },

    TASK_MANAGEMENT: {
        TASK_NAME: 'Tên tác vụ',
        TASK_DESCRIPTION: 'Mô tả tác vụ',
        REQUIRED_POSITION: 'Yêu cầu chức vụ',
        REQUIRED_CONTRACT_TYPE: 'Yêu cầu loại hợp đồng',
        NEW_TASK: 'Thêm tác vụ mới',
        EDIT_TASK: 'Chỉnh sửa thông tin tác vụ',
        DELETE_TASK: 'Xoá tác vụ',
    },

    FACILITY_MAINTENANCE: {
        FACILITY_NAME: 'Tên cơ sở vật chất',
        DESCRIPTION: 'Mô tả cơ sở vật chất',
        STATUS: 'Trạng thái',
        MAINTAINED_START_DATE: 'Ngày bắt đầu bảo trì',
        RESPONSIBLE_STAFF: 'Nhân viên chịu trách nhiệm',
        NEW_FACILITY: 'Thêm yêu cầu bảo trì mới',
    },

    FEEDBACK_MANAGEMENT: {
        FEEDBACK_TITLE: 'Tiêu đề',
        FEEDBACK_CONTENT: 'Nội dung',
        UPLOADED_DATE: 'Ngày gửi',
        SUBJECT: 'Chủ đề',
        USER_NAME: 'Tên người gửi',
        DEPARTMENT: 'Phòng ban',
        POSITION: 'Chức vụ',
        STATUS: {
            STATUS: 'Trạng thái',
            PENDING: 'Hàng chờ',
            PROCESSING: 'Đang xử lý',
            CLOSED: 'Đã đóng',
            CANCELED: 'Đã hủy',
        },
        NEW_FEEDBACK: 'Thêm phản hồi mới',
        EDIT_FEEDBACK: 'Chỉnh sửa thông tin phản hồi',
        DELETE_FEEDBACK: 'Xoá phản hồi',
    },

    PAGE_TITLE: {
        STAFF_MANAGEMENT: 'Quản lý nhân viên',
        FACILITY_MANAGEMENT: 'Quản lý cơ sở vật chất',
        TIMESHEET: 'Quản lý chấm công',
        DEPARTMENT_MANAGEMENT: 'Quản lý phòng ban',
        DEV: 'Phát triển',
    },

    BUTTON: {
        PDF: 'PDF',
        REGISTER: 'Đăng ký',
        CLEAR_ALL: 'Xóa tất cả',
        APPLY: 'Áp dụng',
        DETAIL: 'Chi tiết',
        DELETE: 'Xóa',
        BACK: 'Quay lại',
        SAVE: 'Lưu',
        EDIT: 'Sửa',
        ADD: 'Thêm',
        MONTH_YEAR: 'Tháng năm',
        DEPARTMENT: 'Phòng ban',
        SEARCH: 'Tìm kiếm',
        SORT_BY: 'Sắp xếp theo',
        ACTIONS: 'Thao tác',
        CANCEL: 'Huỷ bỏ',
        SCHEDULE_DETAIL: 'Chi tiết',
        ASSIGN_NEW_TASK: 'Giao tác vụ mới',
    },

    FILTER: {
        TITLE: 'Bộ lọc',
        NO_DATE_SELECTED: 'Chưa chọn ngày',
        DATE_PICKER_LABEL_HELP: 'Sử dụng phím chuột để di chuyển lịch',
    },

    TABLE: {
        EMPTY: 'Không có dữ liệu',
        NOT_COMPLETED: 'Chưa hoàn thành',
        COMPLETED: 'Hoàn thành',
    },

    MODAL: {
        DELETE_CONFIRMATION: 'Bạn có chắc chắn muốn xoá ?',
        YES: 'Có',
        NO: 'Không',
    },

    OVERLAY: {
        PLEASE_WAIT: 'Xin vui lòng chờ...',
    },

    PLACE_HOLDER: {
        PLEASE_SELECT: 'Vui lòng chọn',
        USER_ROLE: 'Vui lòng chọn quyền người dùng',
        DEPARTMENT: 'Vui lòng lựa chọn phòng ban',
        USER_ID: 'Vui lòng nhập tên đăng nhập',
        USER_NAME: 'Vui lòng nhập tên người dùng',
        PWD: 'Vui lòng nhập mật khẩu',
        NEW_PWD: 'Vui lòng nhập lại mật khẩu',
    },

    DATE: {
        YEAR: 'Năm',
        MONTH: 'Tháng',
        DAY: 'Ngày',
    },

    NAVBAR: {
        LOGOUT: 'Đăng xuất',
    },

    DEV: {
        LANGUAGE: 'Ngôn ngữ',
        ENGLISH: 'Tiếng Anh',
        VIETNAMESE: 'Tiếng Việt',
    },

    SPECIAL_CHARACTER: {
        DASH_ARROW: '➟',
    },

    PAGINATION: {
        DISPLAY_PER_PAGE: 'Số lượng hiển thị trên một trang',
        ALL: 'Tất cả',
    },

    TEXT_COLLAPSE: 'Thu gọn',
};
