<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('admin/getlogincode', 'Admin\Auth\LoginController@logincode');
Route::get('admin/login/getlogincode', 'Admin\Auth\LoginController@getLoginCode')->name('getLoginCode')->middleware("guest");
Route::post('admin/login', 'Admin\Auth\LoginController@login');
Route::post('admin/logout', 'Admin\Auth\LoginController@logout');

// Password Reset Routes...
Route::get('admin/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.auth.password.reset');
Route::group([ 'middleware'=> 'admin','prefix' => 'admin'], function () {
//Route::group([ 'prefix' => 'admin'], function () {

    Route::get('/', 'Admin\HomeController@dashboard');

    Route::resource('administrator', 'Admin\AdministratorController');

    Route::get('doctors-list', 'Admin\DoctorsController@doctors_list');
    Route::resource('doctors', 'Admin\DoctorsController');

    Route::get('payment-list', 'Admin\PaymentController@payment_list');
    Route::resource('payment', 'Admin\PaymentController');
    Route::get('payment-confirm/{course_id}/{payment_id}', 'Admin\PaymentController@payment_confirm');

    Route::get('doctors-courses-list', 'Admin\DoctorsCoursesController@doctors_courses_list');
    Route::get('doctors-courses-trash', 'Admin\DoctorsCoursesController@doctors_courses_trash');
    Route::get('doctors-courses-trash-list', 'Admin\DoctorsCoursesController@doctors_courses_trash_list');
    Route::get('doctors-courses-untrash/{id}', 'Admin\DoctorsCoursesController@doctors_courses_untrash');
    Route::get('batch-excel/{paras}', 'Admin\DoctorsCoursesController@batch_excel');
    Route::resource('doctors-courses', 'Admin\DoctorsCoursesController');

    Route::resource('batches-schedules', 'Admin\BatchesSchedulesController');
    Route::get('batches-schedules/lectures-exams-save/{id}', 'Admin\BatchesSchedulesController@lectures_exams_save');
    Route::post('batches-schedules/save-batch-schedule-lectures-exams/{id}', 'Admin\BatchesSchedulesController@save_batch_schedule_lectures_exams');
    Route::get('batches-schedules/print-batch-schedule/{id}', 'Admin\BatchesSchedulesController@print_batch_schedule');


    Route::resource('institutes', 'Admin\InstitutesController');
    Route::resource('courses', 'Admin\CoursesController');

    Route::resource('faculty', 'Admin\FacultyController');
    Route::resource('subjects', 'Admin\SubjectsController');
    Route::resource('service-packages', 'Admin\ServicePackagesController');
    Route::resource('coming-by', 'Admin\ComingByController');

    Route::get('mcq-list', 'Admin\McqController@mcq_list');
    Route::resource('mcq', 'Admin\McqController');

    Route::get('sba-list', 'Admin\SbaController@sba_list');
    Route::resource('sba', 'Admin\SbaController');

    Route::resource('batch', 'Admin\BatchController');
    Route::get('print-batch-doctor-address', 'Admin\BatchController@print_batch_doctor_address');
    Route::post('print-batch-doctors-addresses', 'Admin\BatchController@print_batch_doctors_addresses');
    Route::resource('sessions', 'Admin\SessionsController');
    Route::resource('batch-discipline-fee', 'Admin\BatchDisciplineFeeController');

    Route::get('exam-print/{id}', 'Admin\ExamController@print');
    Route::get('exam-print-ans/{id}', 'Admin\ExamController@print_ans');
    Route::get('exam-print-onlyans/{id}', 'Admin\ExamController@print_onlyans');

    Route::get('upload-result/{id}', 'Admin\ExamController@upload_result');
    Route::get('view-result/{id}', 'Admin\ExamController@view_result');
    Route::post('result-submit', 'Admin\ExamController@result_submit');
    Route::post('result-submit-faculty', 'Admin\ExamController@result_submit_faculty');
    Route::resource('exam', 'Admin\ExamController');

    Route::resource('teacher', 'Admin\TeacherController');

    Route::get('view-course-result/{id}', 'Admin\DoctorsController@view_course_result');

    Route::get('profile', 'Admin\ProfileController@show');
    Route::get('profile-edit', 'Admin\ProfileController@profile_edit');
    Route::post('profile-update', 'Admin\ProfileController@profile_update');

    
    Route::resource('topic', 'Admin\TopicController');


    Route::get('answer/create/{id}', 'Admin\AnswersController@create');
    Route::resource('answer', 'Admin\AnswersController');


    Route::get('users-list', 'Admin\UsersController@users_list');

    Route::get('organization-users/{id}', 'Admin\UsersController@organization_users');
    Route::resource('users', 'Admin\UsersController');


    Route::resource('roles', 'Admin\RolesController');
    Route::resource('permissions', 'Admin\PermissionsController');

    Route::get('system-settings', 'Admin\SettingsController@system_settings');
    Route::post('system-settings', 'Admin\SettingsController@system_settings_update');

    Route::resource('question-types', 'Admin\QuestionTypesController');

    Route::resource('page', 'Admin\PageController');
    Route::resource('online-exam-common-code', 'Admin\OnlineExamCommonCodeController');
    Route::resource('online-exam-link', 'Admin\OnlineExamLinkController');

    Route::resource('online-lecture-address', 'Admin\OnlineLectureAddressController');
    Route::resource('online-lecture-link', 'Admin\OnlineLectureLinkController');

    Route::resource('lecture-video', 'Admin\LectureVideoController');
    Route::resource('lecture-video-link', 'Admin\LectureVideoLinkController');

    Route::resource('lecture-video-batch', 'Admin\LectureVideoBatchController');

    Route::resource('online-exam', 'Admin\OnlineExamController');
    Route::resource('lecture-video-link', 'Admin\LectureVideoLinkController');

    Route::resource('online-exam-batch', 'Admin\OnlineExamBatchController');
    

    Route::get('download-lecture-related-emails/{id}', 'Admin\LectureVideoController@download_emails');
    Route::resource('lecture-sheet', 'Admin\LectureSheetController');
    Route::resource('lecture-sheet-link', 'Admin\LectureSheetLinkController');

    Route::resource('lecture', 'Admin\LectureController');
    Route::resource('room', 'Admin\RoomController');

    Route::get('complain', 'Admin\ComplainController@index');
    Route::get('complain-reply/{id}', 'Admin\ComplainController@edit');
    Route::post('complain-replied', 'Admin\ComplainController@store');

    Route::get('doctor-question', 'Admin\DoctorQuestionController@index');
    Route::get('question-reply/{id}', 'Admin\DoctorQuestionController@edit');
    Route::post('question-replied', 'Admin\DoctorQuestionController@store');

    Route::get('doctor-ask-reply', 'Admin\DoctorAskReplyController@index');
    Route::get('doctor-ask-reply/{id}', 'Admin\DoctorAskReplyController@reply');
    Route::post('doctor-ask-replied', 'Admin\DoctorAskReplyController@reply_store');

    Route::get('doctors-questions', 'Admin\DoctorAskReplyController@doctors_questions');
    Route::get('view-conversation/{id}', 'Admin\DoctorAskReplyController@view_conversation');
    Route::post('reply_conversation', 'Admin\DoctorAskReplyController@reply_conversation');

    Route::get('doctor-complain-list', 'Admin\DoctorComplainController@doctor_complain_list');
    Route::get('view-complain/{id}', 'Admin\DoctorComplainController@view_complain');
    Route::post('reply_complain', 'Admin\DoctorComplainController@reply_complain');

    Route::get('reports-payment', 'Admin\ReportsController@payment_list');

    Route::resource('notice', 'Admin\NoticeController');
    Route::get('notice_show/{id}', 'Admin\NoticeController@show');

    /*ajax*/

    Route::post('permanent-division-district', 'Admin\AjaxController@permanent_division_district');
    Route::post('permanent-district-upazila', 'Admin\AjaxController@permanent_district_upazila');
    Route::post('present-division-district', 'Admin\AjaxController@present_division_district');
    Route::post('present-district-upazila', 'Admin\AjaxController@present_district_upazila');
    Route::post('institutes-courses', 'Admin\AjaxController@institutes_courses');
    Route::post('courses-faculties', 'Admin\AjaxController@courses_faculties');
    Route::post('courses-batches', 'Admin\AjaxController@courses_batches');
    Route::post('faculties-subjects', 'Admin\AjaxController@faculties_subjects');
    Route::post('courses-subjects', 'Admin\AjaxController@courses_subjects');
    Route::post('course-topics', 'Admin\AjaxController@course_topics');
    Route::post('course-topic', 'Admin\AjaxController@course_topic');
    Route::post('faculties-subjects-for-batches-schedules', 'Admin\AjaxController@faculties_subjects_for_batches_schedules');
    Route::post('courses-faculties-subjects-batches', 'Admin\AjaxController@courses_faculties_subjects_batches');
    Route::post('institute-courses', 'Admin\AjaxController@institute_courses');
    Route::post('course-subjects', 'Admin\AjaxController@course_subjects');
    Route::post('faculty-subjects', 'Admin\AjaxController@faculty_subjects');
    Route::post('courses-faculties-batches', 'Admin\AjaxController@courses_faculties_batches');
    Route::post('courses-subjects-batches', 'Admin\AjaxController@courses_subjects_batches');    
    Route::post('institute-courses-for-topics-batches', 'Admin\AjaxController@institute_courses_for_topics_batches');
    Route::post('courses-faculties-topics-batches', 'Admin\AjaxController@courses_faculties_topics_batches');
    Route::post('courses-subjects-topics-batches', 'Admin\AjaxController@courses_subjects_topics_batches');
    Route::post('institute-courses-for-lectures-topics-batches','Admin\AjaxController@institute_courses_for_lectures_topics_batches');
    Route::post('courses-faculties-topics-batches-lectures', 'Admin\AjaxController@courses_faculties_topics_batches_lectures');
    Route::post('courses-subjects-topics-batches-lectures', 'Admin\AjaxController@courses_subjects_topics_batches_lectures');
    Route::post('branch-institute-courses', 'Admin\AjaxController@branch_institute_courses');
    Route::post('branches-courses-faculties-batches', 'Admin\AjaxController@branches_courses_faculties_batches');
    Route::post('branches-courses-subjects-batches', 'Admin\AjaxController@branches_courses_subjects_batches');    
    Route::post('institute-courses-for-lectures-videos','Admin\AjaxController@institute_courses_for_lectures_videos');
    Route::post('lecture-videos','Admin\AjaxController@lecture_videos');
    Route::post('course-changed-in-lecture-videos','Admin\AjaxController@course_changed_in_lecture_videos');
    Route::post('faculty-changed-in-lecture-videos','Admin\AjaxController@faculty_changed_in_lecture_videos');
    Route::post('course-changed-in-batch-discipline-fee','Admin\AjaxController@course_changed_in_batch_discipline_fee');
    Route::post('faculty-changed-in-batch-discipline-fee','Admin\AjaxController@faculty_changed_in_batch_discipline_fee');   
    Route::post('batch-subjects', 'Admin\AjaxController@batch_subjects');
    Route::post('online-exams','Admin\AjaxController@online_exams');
    Route::post('course-changed-in-online-exams','Admin\AjaxController@course_changed_in_online_exams');
    Route::post('faculty-changed-in-online-exams','Admin\AjaxController@faculty_changed_in_online_exams');
    
    


    Route::post('reg-no', 'Admin\AjaxController@reg_no');
    Route::post('set-weekday', 'Admin\AjaxController@set_weekday');
    Route::post('institute-course', 'Admin\AjaxController@institute_course');
    Route::post('course-faculty', 'Admin\AjaxController@course_faculty');
    Route::post('faculty-subject', 'Admin\AjaxController@faculty_subject');
    Route::post('course-subject', 'Admin\AjaxController@course_subject');
    Route::post('question-type-mcq-sba', 'Admin\AjaxController@question_type_mcq_sba');
    Route::get('search-doctors', 'Admin\AjaxController@search_doctors');
    Route::get('search-questions', 'Admin\AjaxController@search_questions');

    Route::post('add-schedule-row', 'Admin\AjaxController@add_schedule_row');

    Route::post('question-info', 'Admin\AjaxController@question_info');

    Route::post('check-bmdc-no', 'Admin\AjaxController@check_bmdc_no');
    Route::post('check-email', 'Admin\AjaxController@check_email');

    Route::post('notice-type', 'Admin\AjaxController@notice_type');
    Route::get('notice_search-doctors', 'Admin\AjaxController@notice_search_doctors');
    Route::post('notice-institute-course', 'Admin\AjaxController@notice_institute_course');
    Route::post('notice-course-batch', 'Admin\AjaxController@notice_course_batch');

});



Route::get('lecture-sheet', 'LectureSheetController@lecture_sheet');
Route::get('lecture-topics/{id}', 'LectureSheetController@lecture_topics');
Route::get('lecture-details/{id}', 'LectureSheetController@lecture_details');
Route::get('topic-lecture-sheets/{lecture_sheet_batch_id}/{topic_id}', 'LectureSheetController@topic_lecture_sheets');

Route::get('lecture-video', 'LectureVideoController@lecture_videos');
Route::get('lecture-video/{course_id}/{batch_id}', 'LectureVideoController@lecture_video');
Route::get('doctor-course-lecture-video/{id}', 'LectureVideoController@doctor_course_lecture_video');
Route::get('lecture-video-details/{id}', 'LectureVideoController@lecture_video_details');

Route::get('online-exam', 'OnlineExamController@online_exams');
Route::get('online-exam/{course_id}/{batch_id}', 'OnlineExamController@online_exam');
Route::get('doctor-course-online-exam/{id}', 'OnlineExamController@doctor_course_online_exam');
Route::get('online-exam-details/{id}', 'OnlineExamController@online_exam_details');


Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('course', 'HomeController@course')->name('course');
Route::get('doctor-admissions', 'DoctorsAdmissionsController@doctor_admissions');
Route::post('doctor-admission-submit', 'DoctorsAdmissionsController@doctor_admission_submit');
Route::get('trash-doctors-courses', 'TrashController@trash_doctors_courses');

Route::get('course', 'MergeController@course');
Route::get('question', 'MergeController@questions');

// Route::get('aboutus', 'PageController@aboutus')->name('aboutus');
// Route::get('ourcourses', 'PageController@ourcourses')->name('ourcourses');
// Route::get('successstories', 'PageController@successstories')->name('successstories');
// Route::get('gallery', 'HomeController@gallery')->name('gallery');
// Route::get('contactus', 'PageController@contactus')->name('contactus');
// Route::get('faq', 'PageController@faq')->name('faq');


//Doctor Profile Links
Route::get('my-profile', ['middleware' => 'auth:doctor', 'uses' => 'HomeController@my_profile'])->name('my_profile');
Route::get('my-profile/edit/{id}', 'HomeController@edit_profile')->name('edit_profile');
Route::post('update-profile', 'HomeController@update_profile')->name('update_profile');

Route::get('doc-profile/print-batch-schedule/{id}', 'Admin\BatchesSchedulesController@print_batch_schedule');
Route::get('doc-profile/view-course-result/{id}', 'HomeController@course_result');

Route::get('my-courses', ['middleware' => 'auth:doctor', 'uses' => 'HomeController@my_courses'])->name('my_courses');
Route::get('my-courses/edit-doctor-course-discipline/{doctor_course_id}', 'DoctorsAdmissionsController@edit_doctor_course_discipline');
Route::post('update-doctor-course-discipline', 'DoctorsAdmissionsController@update_doctor_course_discipline')->name('update_doctor_course_discipline');

Route::get('doctor-result', 'HomeController@doctor_result')->name('doctor_result');

Route::get('payment-details', 'HomeController@payment_details')->name('payment_details');
Route::post('pay-now', 'HomeController@pay_now');
Route::get('payment-success', 'HomeController@payment_success');


Route::get('evaluate-teacher', 'HomeController@evaluate_teacher')->name('evaluate_teacher');
Route::get('online-lecture', 'HomeController@online_lecture')->name('online_lecture');
//Route::get('online-exam', 'HomeController@online_exam')->name('online_exam');

Route::get('result', 'HomeController@result')->name('result');
Route::get('schedule', 'HomeController@schedule')->name('schedule');
Route::get('notice', 'HomeController@notice')->name('notice');
Route::get('notice/notice-details/{id}', 'HomeController@notice_details')->name('notice_details');
Route::get('change-password', 'HomeController@change_password')->name('change_password');
Route::post('update-password', 'HomeController@update_password');
Route::post('register-post', 'PageController@register')->name('register-post');


Route::get('question-box', 'HomeController@question_box')->name('question_box');
Route::get('question-add', 'HomeController@question_add')->name('question_add');

Route::post('course-batch', 'AjaxController@course_batch');
Route::post('batch-lecture-video', 'AjaxController@batch_lecture_video');

Route::post('question-submit', 'HomeController@question_submit');
Route::get('question-answer/{id}', 'HomeController@question_answer');
Route::post('question-submit-final', 'HomeController@question_submit_final');
Route::get('question-answer/{id}', 'HomeController@question_answer');
Route::get('view-answer/{id}', 'HomeController@view_answer');
Route::post('question-again', 'HomeController@question_again');

Route::post('submit-question', 'HomeController@submit_question');
Route::get('question-delete/{id}', 'HomeController@question_delete')->name('question_delete');


Route::get('complain-box', 'HomeController@complain_box')->name('complain_box');
Route::post('submit-complain', 'HomeController@submit_complain');
Route::get('complain-details/{id}', 'HomeController@complain_details')->name('complain_details');
Route::post('complain-again', 'HomeController@complain_again');

Route::post('send-otp', 'HomeController@send_otp');
Route::post('submit-otp', 'HomeController@submit_otp');

Route::post('batch-lecture', 'AjaxController@batch_lecture');

/*Ajax*/
Route::post('permanent-division-district', 'AjaxController@permanent_division_district');
Route::post('permanent-district-upazila', 'AjaxController@permanent_district_upazila');
Route::post('present-division-district', 'AjaxController@present_division_district');
Route::post('present-district-upazila', 'AjaxController@present_district_upazila');

Route::post('institute-courses', 'AjaxController@institute_courses');
Route::post('branches-courses-faculties-batches', 'AjaxController@branches_courses_faculties_batches');
Route::post('branches-courses-subjects-batches', 'AjaxController@branches_courses_subjects_batches');
Route::post('branches-courses-subjects-batches', 'AjaxController@branches_courses_subjects_batches');

Route::post('institute-courses', 'AjaxController@institute_courses');
Route::post('course-sessions-faculties', 'AjaxController@course_sessions_faculties');
Route::post('course-sessions-subjects', 'AjaxController@course_sessions_subjects');
Route::post('courses-branches-subjects-batches', 'AjaxController@courses_branches_subjects_batches');
Route::post('courses-branches-batches', 'AjaxController@courses_branches_batches');
Route::post('course-changed', 'AjaxController@course_changed');
Route::post('faculty-subjects-in-admission', 'AjaxController@faculty_subjects_in_admission');


Route::post('faculty-subjects', 'AjaxController@faculty_subjects');
Route::post('courses-faculties-batches', 'AjaxController@courses_faculties_batches');
Route::post('courses-subjects-batches', 'AjaxController@courses_subjects_batches');
Route::post('reg-no', 'AjaxController@reg_no');

Route::post('batch-details', 'AjaxController@batch_details');
Route::get('payment/{course_id}', 'HomeController@payment');
Route::post('payment-create/{doctor_id}/{course_id}', 'HomeController@payment_create');
Route::get('payment-success/{course_id}/{card_no}/{payment_serial}/{amount}', 'HomeController@payment_success');
Auth::routes();

Route::get('register-first-step', 'DemoPageController@index');
Route::post('register-first-step-submit', 'DemoPageController@register_first_step_submit');
Route::get('register-second-step/{id}', 'DemoPageController@register_second_step');
Route::post('register-second-step-submit', 'DemoPageController@register_second_step_submit');
Route::get('register-third-step/{id}', 'DemoPageController@register_third_step');
Route::post('register-third-step-submit', 'DemoPageController@register_third_step_submit');




// Route::get('/', function(){
//     // $pdf = App::make('snappy.pdf.wrapper');
//     // $html = '<h2>Hello Pdf</h2>';
//     // $pdf->generateFromHtml($html, 'hello.pdf');
//     // $pdf->inline();

//      $pdf = App::make('snappy.pdf.wrapper');
//      $pdf->loadHTML('<h1>Test</h1>');
//      return $pdf->inline();

//     $html = '<h1>Hello Pdf</h1>';
//     $pdf = PDF::loadHtml($html);
//     return $pdf->stream();
// });

