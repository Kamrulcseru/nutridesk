// API Client for NutriDesk Mobile App

const API_BASE_URL = 'https://fighters-spare-shower-meanwhile.trycloudflare.com/api/v1';

export const ApiClient = {
    // Fetch packages
    async getPackages() {
        try {
            const res = await fetch(`${API_BASE_URL}/packages`, { timeout: 3000 });
            const json = await res.json();
            if (json.success && json.data) return json.data;
        } catch (e) {
            // Fallback to local offline cache
        }
        return [
            {
                id: 1,
                code: 'shakti',
                name_bn: 'শক্তি প্যাকেজ (১ জনের জন্য)',
                name_en: 'Shakti Solo Pack (1 Person)',
                grams_per_person_daily: 120,
                price_7_days: 450,
                price_30_days: 1390,
                price_per_person_per_day: 63,
                description_bn: 'প্রতিদিন ডেস্কেই ১০০-১৫০ গ্রাম ফ্রেশ কাটা ফল, হাইজিনিক ফুড-গ্রেড বক্সে।',
                description_en: 'Daily 100-150g portion of cut fresh fruits in food-grade hygienic container.',
                features_bn: ['১ জনের স্বাস্থ্যকর ওয়ান-টাইম পাত্র', 'সকাল ১১টার আগেই অফিস ডেস্কে', 'ছুটির দিনে পজ করার সুবিধা', 'পুষ্টিবিদ অনুমোদিত ভিন্ন মেনু'],
                features_en: ['Single hygienic disposable bowl', 'Delivered before 11:00 AM', 'Pause / skip feature on holidays', 'Nutritionist daily variety'],
                badge_text: 'সবচেয়ে জনপ্রিয় / Best Seller',
            },
            {
                id: 2,
                code: 'bondhu',
                name_bn: 'বন্ধু প্যাকেজ (২ থেকে ৪ জন)',
                name_en: 'Bondhu Buddy Pack (2-4 Persons)',
                grams_per_person_daily: 130,
                price_7_days: 1200,
                price_30_days: 3790,
                price_per_person_per_day: 58,
                description_bn: 'অফিসের সহকর্মীদের সাথে একসাথে শেয়ার করার বিশেষ সাশ্রয়ী প্যাকেজ।',
                description_en: 'Designed for office friends to share fresh healthy fruit portions together.',
                features_bn: ['২-৪ জনের জন্য আলাদা বাউল', 'মাথাপিছু ১৩০+ গ্রাম ফল প্রতিদিন', 'দেশি ফলের সাথে ড্রাগন ও মাল্টা', 'যেকোনো দিন সহজে পজ সুবিধা'],
                features_en: ['Individually portioned bowls', 'Over 130g fruit daily', 'Premium exotic fruit mix', 'Pause anytime'],
                badge_text: 'সাশ্রয়ী বান্ডেল / Save 15%',
            },
            {
                id: 3,
                code: 'office',
                name_bn: 'ফুল অফিস টিম প্যাকেজ (৫-২০+ জন)',
                name_en: 'Full Office Corporate Pack (5-20+)',
                grams_per_person_daily: 140,
                price_7_days: 3200,
                price_30_days: 9990,
                price_per_person_per_day: 52,
                description_bn: 'পুরো অফিস টিম বা ডিপার্টমেন্টের জন্য ফ্রুট ট্রে বা ডেস্কে বক্স।',
                description_en: 'Complete department fruit basket or individual desk boxes.',
                features_bn: ['টিম ট্রে বা আলাদা আলাদা ওয়ান-টাইম বক্স', 'ডায়াবেটিক রোগীদের কাস্টমাইজড ফল', 'মান্থলি কর্পোরেট ইনভয়েস', 'পুষ্টিবিদের ফ্রি ডায়েট পরামর্শ'],
                features_en: ['Corporate tray or desk boxes', 'Tailored packs for Diabetes in team', 'Monthly Corporate Invoice', 'Free nutritionist consultation'],
                badge_text: 'কর্পোরেট সেরা পছন্দ',
            }
        ];
    },

    // Weekly Dietitian Menu
    async getDietitianMenu(condition = 'general') {
        try {
            const res = await fetch(`${API_BASE_URL}/dietitian-plan?condition=${condition}`, { timeout: 3000 });
            const json = await res.json();
            if (json.success && json.data) return json.data;
        } catch (e) {
            // Fallback
        }
        return [
            {
                id: 1,
                day: 'Sunday / রবিবার',
                title_bn: 'ফুজি আপেল + থাই পেয়ারা + মাল্টা',
                title_en: 'Fuji Apple + Thai Guava + Malta',
                calories: 74,
                carbs: '14.5g',
                fiber: '3.8g',
                vitamins: 'Vitamin C & Quercetin',
                note_bn: 'সপ্তাহের প্রথম কর্মদিবসে মেটাবলিজম চাঙ্গা করার আদর্শ কম্বিনেশন।',
                note_en: 'Starts the week by cleansing toxins and boosting alertness.'
            },
            {
                id: 2,
                day: 'Monday / সোমবার',
                title_bn: 'লাল ড্রাগন + পাকা পেঁপে + আপেল',
                title_en: 'Red Dragon + Ripe Papaya + Apple',
                calories: 72,
                carbs: '13.9g',
                fiber: '3.2g',
                vitamins: 'Papain Enzyme & Betalains',
                note_bn: 'কম্পিউটার স্ক্রিন থেকে চোখ সুরক্ষিত রাখতে বিটা-ক্যারোটিন সমৃদ্ধ ফল।',
                note_en: 'Red betalains protect your eyes from screen glare.'
            },
            {
                id: 3,
                day: 'Tuesday / মঙ্গলবার',
                title_bn: 'বেদানা + রসালো মাল্টা + নাশপাতি',
                title_en: 'Pomegranate + Sweet Malta + Pear',
                calories: 82,
                carbs: '16.5g',
                fiber: '3.9g',
                vitamins: 'Punicalagins & Electrolytes',
                note_bn: 'কাজের মানসিক চাপ কমাতে ও ব্রেইন ফাংশন সচল রাখতে সাহায্য করে।',
                note_en: 'Pomegranate punicalagins reduce mental fatigue.'
            },
            {
                id: 4,
                day: 'Wednesday / বুধবার',
                title_bn: 'থাই পেয়ারা + মিষ্টি পেঁপে + মাল্টা',
                title_en: 'Thai Guava + Papaya + Malta',
                calories: 70,
                carbs: '13.1g',
                fiber: '4.2g',
                vitamins: 'Digestive Fiber & Hydration',
                note_bn: 'দুপুরের পর অফিসে যে অলসতা বা ঝিমুনি আসে, তা দূর করে।',
                note_en: 'Keeps stomach light and prevents afternoon sluggishness.'
            },
            {
                id: 5,
                day: 'Thursday / বৃহস্পতিবার',
                title_bn: 'ফুজি আপেল + ড্রাগন ফল + নাশপাতি',
                title_en: 'Fuji Apple + Dragon Fruit + Pear',
                calories: 76,
                carbs: '14.8g',
                fiber: '3.7g',
                vitamins: 'Complete Antioxidant Shield',
                note_bn: 'সপ্তাহের শেষ কাজের দিনে ক্লান্তিহীনভাবে কাজ শেষ করার পুষ্টি উপাদান।',
                note_en: 'Finish the work week energized and ready for the weekend.'
            }
        ];
    }
};
