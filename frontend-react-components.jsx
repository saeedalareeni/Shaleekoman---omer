// ==========================================
// Excellence Training System - React Frontend
// ==========================================

import React, { useState, useEffect, createContext, useContext } from 'react';
import axios from 'axios';

// ==========================================
// API Configuration
// ==========================================
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:3000/api';

const api = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
    }
});

// Add auth token to requests
api.interceptors.request.use(
    config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    error => Promise.reject(error)
);

// ==========================================
// Context Providers
// ==========================================

// Language Context
const LanguageContext = createContext();

export const LanguageProvider = ({ children }) => {
    const [language, setLanguage] = useState(
        localStorage.getItem('language') || 'ar'
    );
    
    const toggleLanguage = () => {
        const newLang = language === 'ar' ? 'en' : 'ar';
        setLanguage(newLang);
        localStorage.setItem('language', newLang);
        document.dir = newLang === 'ar' ? 'rtl' : 'ltr';
    };
    
    useEffect(() => {
        document.dir = language === 'ar' ? 'rtl' : 'ltr';
    }, [language]);
    
    const t = (arText, enText) => language === 'ar' ? arText : enText;
    
    return (
        <LanguageContext.Provider value={{ language, toggleLanguage, t }}>
            {children}
        </LanguageContext.Provider>
    );
};

export const useLanguage = () => useContext(LanguageContext);

// Auth Context
const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    
    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            // Verify token and get user data
            api.get('/auth/verify')
                .then(res => setUser(res.data.user))
                .catch(() => {
                    localStorage.removeItem('token');
                })
                .finally(() => setLoading(false));
        } else {
            setLoading(false);
        }
    }, []);
    
    const login = async (email, password) => {
        const res = await api.post('/auth/login', { email, password });
        localStorage.setItem('token', res.data.token);
        setUser(res.data.user);
        return res.data;
    };
    
    const logout = () => {
        localStorage.removeItem('token');
        setUser(null);
    };
    
    return (
        <AuthContext.Provider value={{ user, login, logout, loading }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => useContext(AuthContext);

// ==========================================
// Main Components
// ==========================================

// Header Component
export const Header = () => {
    const { language, toggleLanguage, t } = useLanguage();
    const { user, logout } = useAuth();
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    
    return (
        <header className="bg-white shadow-md">
            <div className="container mx-auto px-4">
                <div className="flex justify-between items-center py-4">
                    {/* Logo */}
                    <div className="flex items-center">
                        <img 
                            src="/logo.png" 
                            alt="Excellence Learning" 
                            className="h-12"
                        />
                        <h1 className="mr-4 text-2xl font-bold text-primary">
                            {t('اكسلنس للتدريب', 'Excellence Learning')}
                        </h1>
                    </div>
                    
                    {/* Desktop Navigation */}
                    <nav className="hidden md:flex items-center gap-6">
                        <a href="/" className="hover:text-primary">
                            {t('الرئيسية', 'Home')}
                        </a>
                        <a href="/programs" className="hover:text-primary">
                            {t('البرامج', 'Programs')}
                        </a>
                        <a href="/schedule" className="hover:text-primary">
                            {t('جدول التدريب', 'Schedule')}
                        </a>
                        <a href="/certificates" className="hover:text-primary">
                            {t('الشهادات', 'Certificates')}
                        </a>
                        <a href="/consultation" className="hover:text-primary">
                            {t('استشارة مجانية', 'Free Consultation')}
                        </a>
                        
                        {user ? (
                            <>
                                <a href="/dashboard" className="hover:text-primary">
                                    {t('لوحة التحكم', 'Dashboard')}
                                </a>
                                <button onClick={logout} className="btn btn-secondary">
                                    {t('تسجيل خروج', 'Logout')}
                                </button>
                            </>
                        ) : (
                            <a href="/login" className="btn btn-primary">
                                {t('تسجيل دخول', 'Login')}
                            </a>
                        )}
                        
                        <button 
                            onClick={toggleLanguage}
                            className="btn btn-outline"
                        >
                            {language === 'ar' ? 'EN' : 'AR'}
                        </button>
                    </nav>
                    
                    {/* Mobile Menu Button */}
                    <button 
                        className="md:hidden"
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} 
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                
                {/* Mobile Menu */}
                {mobileMenuOpen && (
                    <div className="md:hidden border-t py-4">
                        {/* Mobile navigation items */}
                    </div>
                )}
            </div>
        </header>
    );
};

// Programs List Component
export const ProgramsList = () => {
    const { t } = useLanguage();
    const [programs, setPrograms] = useState([]);
    const [loading, setLoading] = useState(true);
    const [filters, setFilters] = useState({
        category: '',
        search: '',
        page: 1
    });
    
    useEffect(() => {
        fetchPrograms();
    }, [filters]);
    
    const fetchPrograms = async () => {
        setLoading(true);
        try {
            const res = await api.get('/programs', { params: filters });
            setPrograms(res.data.programs);
        } catch (error) {
            console.error('Error fetching programs:', error);
        } finally {
            setLoading(false);
        }
    };
    
    if (loading) {
        return <LoadingSpinner />;
    }
    
    return (
        <div className="container mx-auto px-4 py-8">
            <h2 className="text-3xl font-bold mb-6">
                {t('برامجنا التدريبية', 'Our Training Programs')}
            </h2>
            
            {/* Filters */}
            <div className="mb-6 flex gap-4">
                <input
                    type="text"
                    placeholder={t('بحث...', 'Search...')}
                    className="form-input"
                    value={filters.search}
                    onChange={(e) => setFilters({...filters, search: e.target.value})}
                />
                <select 
                    className="form-select"
                    value={filters.category}
                    onChange={(e) => setFilters({...filters, category: e.target.value})}
                >
                    <option value="">{t('جميع الفئات', 'All Categories')}</option>
                    <option value="1">{t('إدارة المشاريع', 'Project Management')}</option>
                    <option value="2">{t('التخطيط الاستراتيجي', 'Strategic Planning')}</option>
                    <option value="3">{t('إدارة التغيير', 'Change Management')}</option>
                </select>
            </div>
            
            {/* Programs Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {programs.map(program => (
                    <ProgramCard key={program.id} program={program} />
                ))}
            </div>
        </div>
    );
};

// Program Card Component
export const ProgramCard = ({ program }) => {
    const { language, t } = useLanguage();
    
    return (
        <div className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <div className="p-6">
                <div className="text-sm text-gray-500 mb-2">
                    {language === 'ar' ? program.category_name_ar : program.category_name_en}
                </div>
                
                <h3 className="text-xl font-semibold mb-3">
                    {language === 'ar' ? program.title_ar : program.title_en}
                </h3>
                
                <p className="text-gray-600 mb-4 line-clamp-3">
                    {language === 'ar' ? program.description_ar : program.description_en}
                </p>
                
                <div className="flex justify-between items-center mb-4">
                    <span className="flex items-center text-gray-500">
                        <ClockIcon className="w-4 h-4 mr-1" />
                        {program.duration_days} {t('أيام', 'days')}
                    </span>
                    <span className="text-lg font-bold text-primary">
                        {program.price} {t('ريال', 'SAR')}
                    </span>
                </div>
                
                {program.certificate_name_ar && (
                    <div className="mb-4 p-2 bg-blue-50 rounded text-sm">
                        <CertificateIcon className="w-4 h-4 inline mr-1" />
                        {language === 'ar' ? program.certificate_name_ar : program.certificate_name_en}
                    </div>
                )}
                
                <div className="flex gap-2">
                    <a 
                        href={`/programs/${program.id}`}
                        className="btn btn-primary flex-1"
                    >
                        {t('التفاصيل', 'Details')}
                    </a>
                    {program.upcoming_sessions > 0 && (
                        <a 
                            href={`/register/${program.id}`}
                            className="btn btn-success flex-1"
                        >
                            {t('سجل الآن', 'Register Now')}
                        </a>
                    )}
                </div>
            </div>
        </div>
    );
};

// Registration Form Component
export const RegistrationForm = ({ scheduleId }) => {
    const { t } = useLanguage();
    const { user } = useAuth();
    const [loading, setLoading] = useState(false);
    const [schedule, setSchedule] = useState(null);
    const [trainees, setTrainees] = useState([{
        name: user?.name || '',
        email: user?.email || '',
        phone: '',
        job_title: ''
    }]);
    
    useEffect(() => {
        fetchScheduleDetails();
    }, [scheduleId]);
    
    const fetchScheduleDetails = async () => {
        try {
            const res = await api.get(`/schedule/${scheduleId}`);
            setSchedule(res.data);
        } catch (error) {
            console.error('Error fetching schedule:', error);
        }
    };
    
    const addTrainee = () => {
        if (trainees.length < 5) {
            setTrainees([...trainees, {
                name: '',
                email: '',
                phone: '',
                job_title: ''
            }]);
        }
    };
    
    const removeTrainee = (index) => {
        setTrainees(trainees.filter((_, i) => i !== index));
    };
    
    const updateTrainee = (index, field, value) => {
        const updated = [...trainees];
        updated[index][field] = value;
        setTrainees(updated);
    };
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        
        try {
            const res = await api.post('/registrations', {
                schedule_id: scheduleId,
                trainees
            });
            
            // Redirect to payment page
            window.location.href = `/payment/${res.data.registrationIds[0]}`;
        } catch (error) {
            alert(t('حدث خطأ في التسجيل', 'Registration error'));
        } finally {
            setLoading(false);
        }
    };
    
    if (!schedule) return <LoadingSpinner />;
    
    return (
        <form onSubmit={handleSubmit} className="max-w-4xl mx-auto p-6">
            <h2 className="text-2xl font-bold mb-6">
                {t('التسجيل في البرنامج', 'Program Registration')}
            </h2>
            
            {/* Program Summary */}
            <div className="bg-gray-50 p-4 rounded mb-6">
                <h3 className="font-semibold mb-2">{schedule.program_title_ar}</h3>
                <p>{t('التاريخ:', 'Date:')} {schedule.start_date} - {schedule.end_date}</p>
                <p>{t('المدرب:', 'Trainer:')} {schedule.trainer_name}</p>
                <p>{t('السعر:', 'Price:')} {schedule.price} {t('ريال', 'SAR')}</p>
            </div>
            
            {/* Trainees Forms */}
            {trainees.map((trainee, index) => (
                <div key={index} className="border rounded p-4 mb-4">
                    <div className="flex justify-between items-center mb-4">
                        <h4 className="font-semibold">
                            {t(`المتدرب ${index + 1}`, `Trainee ${index + 1}`)}
                        </h4>
                        {index > 0 && (
                            <button
                                type="button"
                                onClick={() => removeTrainee(index)}
                                className="text-red-500 hover:text-red-700"
                            >
                                {t('إزالة', 'Remove')}
                            </button>
                        )}
                    </div>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="block mb-2">
                                {t('الاسم الكامل', 'Full Name')} *
                            </label>
                            <input
                                type="text"
                                required
                                className="form-input w-full"
                                value={trainee.name}
                                onChange={(e) => updateTrainee(index, 'name', e.target.value)}
                            />
                        </div>
                        
                        <div>
                            <label className="block mb-2">
                                {t('البريد الإلكتروني', 'Email')} *
                            </label>
                            <input
                                type="email"
                                required
                                className="form-input w-full"
                                value={trainee.email}
                                onChange={(e) => updateTrainee(index, 'email', e.target.value)}
                            />
                        </div>
                        
                        <div>
                            <label className="block mb-2">
                                {t('رقم الجوال', 'Mobile Number')} *
                            </label>
                            <input
                                type="tel"
                                required
                                className="form-input w-full"
                                value={trainee.phone}
                                onChange={(e) => updateTrainee(index, 'phone', e.target.value)}
                            />
                        </div>
                        
                        <div>
                            <label className="block mb-2">
                                {t('المسمى الوظيفي', 'Job Title')} *
                            </label>
                            <input
                                type="text"
                                required
                                className="form-input w-full"
                                value={trainee.job_title}
                                onChange={(e) => updateTrainee(index, 'job_title', e.target.value)}
                            />
                        </div>
                    </div>
                </div>
            ))}
            
            {trainees.length < 5 && (
                <button
                    type="button"
                    onClick={addTrainee}
                    className="btn btn-outline mb-6"
                >
                    {t('إضافة متدرب آخر', 'Add Another Trainee')}
                </button>
            )}
            
            <button
                type="submit"
                disabled={loading}
                className="btn btn-primary w-full"
            >
                {loading ? t('جاري التسجيل...', 'Registering...') : t('تأكيد التسجيل', 'Confirm Registration')}
            </button>
        </form>
    );
};

// Consultation Form Component
export const ConsultationForm = () => {
    const { t } = useLanguage();
    const [loading, setLoading] = useState(false);
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        phone: '',
        company: '',
        job_title: '',
        consultation_type: '',
        consultation_topic: '',
        preferred_date: '',
        preferred_time: '',
        notes: ''
    });
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        
        try {
            await api.post('/consultations', formData);
            alert(t('تم إرسال طلبك بنجاح', 'Your request has been sent successfully'));
            // Reset form
            setFormData({
                name: '',
                email: '',
                phone: '',
                company: '',
                job_title: '',
                consultation_type: '',
                consultation_topic: '',
                preferred_date: '',
                preferred_time: '',
                notes: ''
            });
        } catch (error) {
            alert(t('حدث خطأ في إرسال الطلب', 'Error sending request'));
        } finally {
            setLoading(false);
        }
    };
    
    return (
        <div className="max-w-2xl mx-auto p-6">
            <h2 className="text-3xl font-bold mb-6 text-center">
                {t('احجز استشارة تدريب مجانية', 'Book a Free Training Consultation')}
            </h2>
            
            <div className="bg-blue-50 p-4 rounded mb-6">
                <h3 className="font-semibold mb-2">
                    {t('كيف تعمل الاستشارة المجانية؟', 'How does the free consultation work?')}
                </h3>
                <ol className="list-decimal list-inside space-y-2">
                    <li>{t('حجز موعد', 'Book an appointment')}</li>
                    <li>{t('تصميم المسار التدريبي', 'Design training path')}</li>
                    <li>{t('تسليم المسار', 'Deliver the path')}</li>
                </ol>
            </div>
            
            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label className="block mb-2">
                        {t('الاسم', 'Name')} *
                    </label>
                    <input
                        type="text"
                        required
                        className="form-input w-full"
                        value={formData.name}
                        onChange={(e) => setFormData({...formData, name: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('البريد الإلكتروني', 'Email')} *
                    </label>
                    <input
                        type="email"
                        required
                        className="form-input w-full"
                        value={formData.email}
                        onChange={(e) => setFormData({...formData, email: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('رقم الجوال', 'Mobile Number')} *
                    </label>
                    <input
                        type="tel"
                        required
                        className="form-input w-full"
                        value={formData.phone}
                        onChange={(e) => setFormData({...formData, phone: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('الشركة', 'Company')}
                    </label>
                    <input
                        type="text"
                        className="form-input w-full"
                        value={formData.company}
                        onChange={(e) => setFormData({...formData, company: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('المسمى الوظيفي', 'Job Title')} *
                    </label>
                    <input
                        type="text"
                        required
                        className="form-input w-full"
                        value={formData.job_title}
                        onChange={(e) => setFormData({...formData, job_title: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('نوع الاستشارة', 'Consultation Type')} *
                    </label>
                    <select
                        required
                        className="form-select w-full"
                        value={formData.consultation_type}
                        onChange={(e) => setFormData({...formData, consultation_type: e.target.value})}
                    >
                        <option value="">{t('اختر...', 'Choose...')}</option>
                        <option value="individual">{t('استشارة فردية', 'Individual Consultation')}</option>
                        <option value="corporate">{t('استشارة مؤسسية', 'Corporate Consultation')}</option>
                        <option value="career">{t('استشارة مهنية', 'Career Consultation')}</option>
                    </select>
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('موضوع الاستشارة', 'Consultation Topic')} *
                    </label>
                    <textarea
                        required
                        className="form-textarea w-full"
                        rows="3"
                        value={formData.consultation_topic}
                        onChange={(e) => setFormData({...formData, consultation_topic: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('التاريخ المفضل', 'Preferred Date')}
                    </label>
                    <input
                        type="date"
                        className="form-input w-full"
                        value={formData.preferred_date}
                        onChange={(e) => setFormData({...formData, preferred_date: e.target.value})}
                    />
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('الوقت المناسب للاتصال', 'Preferred Contact Time')}
                    </label>
                    <select
                        className="form-select w-full"
                        value={formData.preferred_time}
                        onChange={(e) => setFormData({...formData, preferred_time: e.target.value})}
                    >
                        <option value="">{t('اختر...', 'Choose...')}</option>
                        <option value="morning">{t('صباحاً (9-12)', 'Morning (9-12)')}</option>
                        <option value="afternoon">{t('ظهراً (12-3)', 'Afternoon (12-3)')}</option>
                        <option value="evening">{t('مساءً (3-6)', 'Evening (3-6)')}</option>
                    </select>
                </div>
                
                <div>
                    <label className="block mb-2">
                        {t('ملاحظات', 'Notes')}
                    </label>
                    <textarea
                        className="form-textarea w-full"
                        rows="3"
                        value={formData.notes}
                        onChange={(e) => setFormData({...formData, notes: e.target.value})}
                    />
                </div>
                
                <button
                    type="submit"
                    disabled={loading}
                    className="btn btn-primary w-full"
                >
                    {loading ? t('جاري الإرسال...', 'Sending...') : t('إرسال الطلب', 'Send Request')}
                </button>
            </form>
        </div>
    );
};

// Loading Spinner Component
const LoadingSpinner = () => (
    <div className="flex justify-center items-center p-8">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
    </div>
);

// Icon Components
const ClockIcon = ({ className }) => (
    <svg className={className} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} 
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
);

const CertificateIcon = ({ className }) => (
    <svg className={className} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} 
            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
    </svg>
);

export default {
    Header,
    ProgramsList,
    ProgramCard,
    RegistrationForm,
    ConsultationForm,
    LanguageProvider,
    AuthProvider,
    useLanguage,
    useAuth
};
