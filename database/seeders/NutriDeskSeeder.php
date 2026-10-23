<?php

namespace Database\Seeders;

use App\Models\DailyDelivery;
use App\Models\DietitianMenu;
use App\Models\Fruit;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NutriDeskSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Core Users with Roles
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@nutridesk.com'],
            [
                'name' => 'Dr. Kamrul Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'phone' => '+8801700000001',
                'office_name' => 'NutriDesk HQ',
                'office_address' => 'Gulshan 2, Dhaka-1212',
                'office_floor' => 'Floor 8',
                'desk_number' => 'Desk 801',
                'health_condition' => 'general',
                'preferred_language' => 'bn',
                'is_active' => true,
            ]
        );

        $staffUser = User::updateOrCreate(
            ['email' => 'staff@nutridesk.com'],
            [
                'name' => 'Rahim Delivery & Kitchen Ops',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'phone' => '+8801700000002',
                'office_name' => 'NutriDesk Operations Center',
                'office_address' => 'Banani, Dhaka',
                'office_floor' => 'Ground Floor',
                'desk_number' => 'Prep-Desk-1',
                'health_condition' => 'general',
                'preferred_language' => 'bn',
                'is_active' => true,
            ]
        );

        $dietitianUser = User::updateOrCreate(
            ['email' => 'dietitian@nutridesk.com'],
            [
                'name' => 'Dr. Nusrat Jahan (Chief Nutritionist)',
                'password' => Hash::make('nutri123'),
                'role' => 'dietitian',
                'phone' => '+8801700000003',
                'office_name' => 'NutriDesk Nutrition Lab',
                'office_address' => 'Dhanmondi, Dhaka',
                'office_floor' => 'Floor 3',
                'desk_number' => 'Lab-301',
                'health_condition' => 'general',
                'preferred_language' => 'en',
                'is_active' => true,
            ]
        );

        $customer1 = User::updateOrCreate(
            ['email' => 'tanvir@techcorp.com'],
            [
                'name' => 'Tanvir Ahmed',
                'password' => Hash::make('user123'),
                'role' => 'customer',
                'phone' => '+8801811112233',
                'office_name' => 'BrainStation 23 Ltd',
                'office_address' => 'Floor 4, Plot 2, Mirpur DOHS, Dhaka',
                'office_floor' => '4th Floor',
                'desk_number' => 'Desk #42 (Dev Team)',
                'health_condition' => 'general',
                'allergies_notes' => 'কলা খেলে হালকা এলার্জি হয় (Mild banana allergy)',
                'preferred_delivery_time' => '10:00 AM - 10:45 AM',
                'preferred_language' => 'bn',
                'is_active' => true,
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'farhana.hr@innovate.com'],
            [
                'name' => 'Farhana Kabir',
                'password' => Hash::make('user123'),
                'role' => 'customer',
                'phone' => '+8801922334455',
                'office_name' => 'Innovate FinTech Hub',
                'office_address' => 'Tower 71, Karwan Bazar, Dhaka',
                'office_floor' => '9th Floor',
                'desk_number' => 'Cabin HR-02',
                'health_condition' => 'diabetes',
                'allergies_notes' => 'ডায়াবেটিস পেশেন্ট - কম মিষ্টি ও লো জিআই ফল প্রয়োজন',
                'preferred_delivery_time' => '10:30 AM - 11:30 AM',
                'preferred_language' => 'bn',
                'is_active' => true,
            ]
        );

        // 2. Seed Packages
        $packages = [
            [
                'name_en' => 'Shakti Solo Pack (1 Person)',
                'name_bn' => 'শক্তি প্যাকেজ (১ জনের জন্য)',
                'code' => 'shakti',
                'slug' => 'shakti-solo-pack',
                'min_persons' => 1,
                'max_persons' => 1,
                'grams_per_person_daily' => 120,
                'price_7_days' => 450.00,
                'price_30_days' => 1390.00,
                'price_per_person_per_day' => 63.00,
                'description_en' => 'Perfect daily 100-150g portion of cut fresh fruits in food-grade hygienic container directly at your office desk.',
                'description_bn' => 'প্রতিদিন ডেস্কেই ১০০-১৫০ গ্রাম ফ্রেশ কাটা ফল, সম্পূর্ণ হাইজিনিক ও ফুড-গ্রেড বক্সে। কর্মক্ষেত্রে ক্লান্তি দূর করে এনার্জি বাড়িয়ে তোলে।',
                'features_en' => [
                    '100-150g fresh seasonal mixed fruits daily',
                    'Single person hygienic disposable bowl',
                    'Delivered before 11:00 AM directly to desk',
                    'Pause / skip feature on holidays',
                    'Nutritionist curated daily variety'
                ],
                'features_bn' => [
                    'প্রতিদিন ১০০-১৫০ গ্রাম পুষ্টিকর ফ্রেশ ফল',
                    '১ জনের স্বাস্থ্যকর ওয়ান-টাইম ফুড-গ্রেড পাত্র',
                    'সকাল ১১টার আগেই সরাসরি অফিস ডেস্কে পৌঁছে দেওয়া',
                    'ছুটির দিনে পজ / স্কিপ করার সুবিধা',
                    'পুষ্টিবিদ অনুমোদিত প্রতিদিনের ভিন্ন মেনু'
                ],
                'badge_text' => 'সবচেয়ে জনপ্রিয় / Best Seller',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Bondhu Buddy Pack (2-4 Persons)',
                'name_bn' => 'বন্ধু প্যাকেজ (২ থেকে ৪ জনের জন্য)',
                'code' => 'bondhu',
                'slug' => 'bondhu-buddy-pack',
                'min_persons' => 2,
                'max_persons' => 4,
                'grams_per_person_daily' => 130,
                'price_7_days' => 1200.00,
                'price_30_days' => 3790.00,
                'price_per_person_per_day' => 58.00,
                'description_en' => 'Designed for office friends and colleagues to share fresh healthy fruit portions together at a discounted rate.',
                'description_bn' => 'অফিসের সহকর্মীদের সাথে একসাথে স্বাস্থ্যকর ফল খাওয়ার বিশেষ সাশ্রয়ী প্যাকেজ। প্রত্যেকে পাবেন নিজস্ব ফ্রুট বাউল।',
                'features_en' => [
                    'Individually portioned bowls for 2-4 persons',
                    'Over 130g fruit per person daily',
                    'Includes premium exotic fruits (Dragon, Malta, Pear)',
                    'Eco-friendly packaging option',
                    'Pause or reschedule anytime'
                ],
                'features_bn' => [
                    '২-৪ জনের জন্য আলাদা আলাদা বাউল প্যাক',
                    'মাথাপিছু ১৩০+ গ্রাম ফল প্রতিদিন',
                    'দেশি ফলের সাথে ড্রাগন, মাল্টা ও বিদেশি ফলের মিক্স',
                    'পরিবেশবান্ধব প্যাকেজিং অপশন',
                    'যেকোনো দিন সহজে পজ বা রি-শিডিউল সুবিধা'
                ],
                'badge_text' => 'সাশ্রয়ী বান্ডেল / Save 15%',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Full Office Corporate Pack (5-20+ Persons)',
                'name_bn' => 'ফুল অফিস টিম প্যাকেজ (৫ থেকে ২০+ জন)',
                'code' => 'office',
                'slug' => 'full-office-pack',
                'min_persons' => 5,
                'max_persons' => 25,
                'grams_per_person_daily' => 140,
                'price_7_days' => 3200.00,
                'price_30_days' => 9990.00,
                'price_per_person_per_day' => 52.00,
                'description_en' => 'Complete team & corporate department fruit basket or individual desk boxes with monthly corporate invoicing.',
                'description_bn' => 'পুরো অফিস টিম বা ডিপার্টমেন্টের জন্য ফ্রুট ট্রে বা পার্সোনালাইজড ডেস্কে বক্স। কর্পোরেট মান্থলি বিলিং সুবিধা রয়েছে।',
                'features_en' => [
                    'Corporate tray or individual desk boxes',
                    'Tailored packs for Diabetes/Kidney patients in team',
                    'Dedicated account manager & priority delivery',
                    'Monthly GST / Corporate Invoice',
                    'Free nutritionist consultation for office team'
                ],
                'features_bn' => [
                    'টিম ট্রে অথবা ডেস্কে আলাদা আলাদা ওয়ান-টাইম বক্স',
                    'টিমের ডায়াবেটিস বা হার্ট রোগীদের জন্য কাস্টমাইজড ফল',
                    'ডেডিকেটেড অ্যাকাউন্ট ম্যানেজার ও প্রায়োরিটি ডেলিভারি',
                    'মান্থলি কর্পোরেট ইনভয়েস ও ভ্যাট রিসিপ্ট',
                    'টিমের জন্য পুষ্টিবিদের ফ্রি ডায়েট পরামর্শ'
                ],
                'badge_text' => 'কর্পোরেট সেরা পছন্দ / Corporate Choice',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ]
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['code' => $pkg['code']], $pkg);
        }

        // 3. Seed Fruits Database
        $fruits = [
            [
                'name_en' => 'Fuji Apple',
                'name_bn' => 'ফুজি আপেল',
                'slug' => 'fuji-apple',
                'origin' => 'imported',
                'category' => 'fresh',
                'calories_per_100g' => 52.00,
                'sugar_g_per_100g' => 10.30,
                'potassium_mg_per_100g' => 107.00,
                'fiber_g_per_100g' => 2.40,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'Rich in quercetin and pectin fiber, promotes digestive wellness and steady energy.',
                'benefits_bn' => 'কোয়ারসেটিন ও পেকটিন ফাইবার সমৃদ্ধ, পেটের স্বাস্থ্য ভালো রাখে ও সারাদিন শক্তি যোগায়।',
                'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Thai Guava',
                'name_bn' => 'থাই পেয়ারা',
                'slug' => 'thai-guava',
                'origin' => 'local',
                'category' => 'fresh',
                'calories_per_100g' => 68.00,
                'sugar_g_per_100g' => 8.90,
                'potassium_mg_per_100g' => 417.00,
                'fiber_g_per_100g' => 5.40,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'Super high Vitamin C (4x of orange) and dietary fiber, ideal for blood sugar regulation.',
                'benefits_bn' => 'কমলার চেয়েও ৪ গুণ বেশি ভিটামিন সি ও প্রচুর ফাইবার রয়েছে, ডায়াবেটিস নিয়ন্ত্রণে অত্যন্ত কার্যকরী।',
                'image_url' => 'https://images.unsplash.com/photo-1536511132770-e5058c7e8c46?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Ripe Papaya',
                'name_bn' => 'মিষ্টি পাকা পেঁপে',
                'slug' => 'ripe-papaya',
                'origin' => 'local',
                'category' => 'fresh',
                'calories_per_100g' => 43.00,
                'sugar_g_per_100g' => 7.80,
                'potassium_mg_per_100g' => 182.00,
                'fiber_g_per_100g' => 1.70,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'Contains papain enzyme that prevents bloating after office lunch and improves digestion.',
                'benefits_bn' => 'প্যাপাইন এনজাইম সমৃদ্ধ যা দুপুরের খাবারের পর এসিডিটি ও পেট ফাঁপা দূর করে সহজে হজমে সাহায্য করে।',
                'image_url' => 'https://images.unsplash.com/photo-1517282009859-f000ec3b26fe?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Red Dragon Fruit',
                'name_bn' => 'লাল ড্রাগন ফল',
                'slug' => 'red-dragon-fruit',
                'origin' => 'local',
                'category' => 'fresh',
                'calories_per_100g' => 60.00,
                'sugar_g_per_100g' => 7.60,
                'potassium_mg_per_100g' => 190.00,
                'fiber_g_per_100g' => 2.90,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'summer_monsoon',
                'benefits_en' => 'Loaded with betalains and prebiotics, boosts immunity and controls cellular aging.',
                'benefits_bn' => 'বেটালেইন ও শক্তিশালী অ্যান্টিঅক্সিডেন্ট সমৃদ্ধ, রোগ প্রতিরোধ ক্ষমতা বাড়ায় ও রক্ত সঞ্চালন সচল রাখে।',
                'image_url' => 'https://images.unsplash.com/photo-1527325678964-54921661f888?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Egyptian Malta / Orange',
                'name_bn' => 'রসালো মিষ্টি মাল্টা',
                'slug' => 'egyptian-malta',
                'origin' => 'imported',
                'category' => 'fresh',
                'calories_per_100g' => 47.00,
                'sugar_g_per_100g' => 9.35,
                'potassium_mg_per_100g' => 181.00,
                'fiber_g_per_100g' => 2.40,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'High natural electrolytes and Vitamin C that eliminates office fatigue instantly.',
                'benefits_bn' => 'প্রচুর প্রাকৃতিক ইলেকট্রোলাইটস ও ভিটামিন সি যা অফিস টাইমের ক্লান্তি ও অলসতা নিমেষেই দূর করে।',
                'image_url' => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab5b?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Ruby Pomegranate',
                'name_bn' => 'বেদানা / ডালিম',
                'slug' => 'ruby-pomegranate',
                'origin' => 'imported',
                'category' => 'fresh',
                'calories_per_100g' => 83.00,
                'sugar_g_per_100g' => 13.60,
                'potassium_mg_per_100g' => 236.00,
                'fiber_g_per_100g' => 4.00,
                'safe_for_diabetes' => false, // High natural sugars for strict diabetics
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'Cardiovascular booster, improves blood pressure and haemoglobin levels.',
                'benefits_bn' => 'হার্ট ভালো রাখে, রক্তে হিমোগ্লোবিন বাড়ায় ও ব্লাড প্রেশার নিয়ন্ত্রণে রাখতে সাহায্য করে।',
                'image_url' => 'https://images.unsplash.com/photo-1541344999736-83eca872f242?w=400',
                'is_active' => true,
            ],
            [
                'name_en' => 'Crisp Green Pear',
                'name_bn' => 'সবুজ নাশপাতি',
                'slug' => 'green-pear',
                'origin' => 'imported',
                'category' => 'fresh',
                'calories_per_100g' => 57.00,
                'sugar_g_per_100g' => 9.80,
                'potassium_mg_per_100g' => 116.00,
                'fiber_g_per_100g' => 3.10,
                'safe_for_diabetes' => true,
                'safe_for_kidney' => true,
                'safe_for_heart' => true,
                'season' => 'all_year',
                'benefits_en' => 'Low glycemic index fruit that keeps hunger away without glucose spikes.',
                'benefits_bn' => 'কম গ্লাইসেমিক ইনডেক্স থাকায় ডায়াবেটিস রোগীদের জন্য অত্যন্ত নিরাপদ ও তৃপ্তিদায়ক।',
                'image_url' => 'https://images.unsplash.com/photo-1514756331096-242fdeb70d4a?w=400',
                'is_active' => true,
            ]
        ];

        foreach ($fruits as $fruit) {
            Fruit::updateOrCreate(['slug' => $fruit['slug']], $fruit);
        }

        // 4. Seed Dietitian Daily Menus for Office Days (Sunday - Thursday)
        $dietitianMenus = [
            // Sunday
            [
                'day_of_week' => 'sunday',
                'health_condition' => 'general',
                'title_en' => 'Start Strong Trio: Fuji Apple + Guava + Malta',
                'title_bn' => 'রবিবারের শক্তি: ফুজি আপেল + থাই পেয়ারা + মিষ্টি মাল্টা',
                'fruits_list' => [
                    ['fruit' => 'Fuji Apple', 'fruit_bn' => 'ফুজি আপেল', 'grams' => 50],
                    ['fruit' => 'Thai Guava', 'fruit_bn' => 'থাই পেয়ারা', 'grams' => 50],
                    ['fruit' => 'Malta', 'fruit_bn' => 'মাল্টা স্লাইস', 'grams' => 40],
                ],
                'calories_total' => 74,
                'carbs_g' => 14.50,
                'fiber_g' => 3.80,
                'vitamins_focus' => 'Vitamin C (120% DV), Quercetin',
                'dietitian_advice_en' => 'Starts the week by cleansing toxins and boosting alertness after weekend slumber.',
                'dietitian_advice_bn' => 'সপ্তাহের প্রথম কর্মদিবসে মেটাবলিজম চাঙ্গা করতে এবং মনোযোগ ধরে রাখতে আদর্শ পুষ্টি উপাদান।',
                'is_active' => true,
            ],
            [
                'day_of_week' => 'sunday',
                'health_condition' => 'diabetes',
                'title_en' => 'Low-GI Balance: Green Pear + Guava + Dragon Fruit',
                'title_bn' => 'ডায়াবেটিস কেয়ার: নাশপাতি + পেয়ারা + লাল ড্রাগন ফল',
                'fruits_list' => [
                    ['fruit' => 'Green Pear', 'fruit_bn' => 'সবুজ নাশপাতি', 'grams' => 45],
                    ['fruit' => 'Thai Guava', 'fruit_bn' => 'থাই পেয়ারা', 'grams' => 55],
                    ['fruit' => 'Dragon Fruit', 'fruit_bn' => 'ড্রাগন ফল', 'grams' => 40],
                ],
                'calories_total' => 68,
                'carbs_g' => 11.20,
                'fiber_g' => 4.60,
                'vitamins_focus' => 'High Fiber & Slow-Release Carbs',
                'dietitian_advice_en' => 'High soluble fiber prevents mid-morning blood sugar spikes.',
                'dietitian_advice_bn' => 'উচ্চমাত্রার সল্যুয়েবল ফাইবার থাকায় রক্তে সুগারের মাত্রা একদম স্থিতিশীল রাখে।',
                'is_active' => true,
            ],
            // Monday
            [
                'day_of_week' => 'monday',
                'health_condition' => 'general',
                'title_en' => 'Vitality Feast: Dragon Fruit + Ripe Papaya + Apple',
                'title_bn' => 'সোমবারে তরতাজা: লাল ড্রাগন + পাকা পেঁপে + আপেল',
                'fruits_list' => [
                    ['fruit' => 'Dragon Fruit', 'fruit_bn' => 'লাল ড্রাগন', 'grams' => 50],
                    ['fruit' => 'Ripe Papaya', 'fruit_bn' => 'পাকা পেঁপে', 'grams' => 50],
                    ['fruit' => 'Fuji Apple', 'fruit_bn' => 'আপেল স্লাইস', 'grams' => 40],
                ],
                'calories_total' => 72,
                'carbs_g' => 13.90,
                'fiber_g' => 3.20,
                'vitamins_focus' => 'Papain Enzyme, Betalains & Beta-Carotene',
                'dietitian_advice_en' => 'Papain enzyme soothes digestion while red betalains protect your eyes from screen glare.',
                'dietitian_advice_bn' => 'কম্পিউটার স্ক্রিনের ক্ষতিকর প্রভাব থেকে চোখ সুরক্ষিত রাখতে বিটা-ক্যারোটিন সমৃদ্ধ ফল।',
                'is_active' => true,
            ],
            // Tuesday
            [
                'day_of_week' => 'tuesday',
                'health_condition' => 'general',
                'title_en' => 'Antioxidant Power: Pomegranate + Malta + Pear',
                'title_bn' => 'মঙ্গলবারের সুরক্ষা: বেদানা + রসালো মাল্টা + নাশপাতি',
                'fruits_list' => [
                    ['fruit' => 'Ruby Pomegranate', 'fruit_bn' => 'বেদানা দানা', 'grams' => 40],
                    ['fruit' => 'Malta', 'fruit_bn' => 'মিষ্টি মাল্টা', 'grams' => 50],
                    ['fruit' => 'Green Pear', 'fruit_bn' => 'নাশপাতি', 'grams' => 45],
                ],
                'calories_total' => 82,
                'carbs_g' => 16.50,
                'fiber_g' => 3.90,
                'vitamins_focus' => 'Punicalagins & Vitamin C',
                'dietitian_advice_en' => 'Pomegranate punicalagins reduce mental stress and fatigue.',
                'dietitian_advice_bn' => 'কাজের মানসিক চাপ কমাতে ও ব্রেইন ফাংশন সচল রাখতে সাহায্য করে।',
                'is_active' => true,
            ],
            // Wednesday
            [
                'day_of_week' => 'wednesday',
                'health_condition' => 'general',
                'title_en' => 'Digestive Boost: Thai Guava + Papaya + Malta',
                'title_bn' => 'বুধবারের সতেজতা: থাই পেয়ারা + পেঁপে + মাল্টা',
                'fruits_list' => [
                    ['fruit' => 'Thai Guava', 'fruit_bn' => 'থাই পেয়ারা', 'grams' => 60],
                    ['fruit' => 'Ripe Papaya', 'fruit_bn' => 'পাকা পেঁপে', 'grams' => 45],
                    ['fruit' => 'Malta', 'fruit_bn' => 'মাল্টা', 'grams' => 40],
                ],
                'calories_total' => 70,
                'carbs_g' => 13.10,
                'fiber_g' => 4.20,
                'vitamins_focus' => 'Digestive Fiber & Hydration',
                'dietitian_advice_en' => 'Keeps stomach light and prevents sluggishness after office lunch.',
                'dietitian_advice_bn' => 'দুপুরের পর অফিসে যে অলসতা বা ঝিমুনি আসে, তা পুরোপুরি রোধ করবে।',
                'is_active' => true,
            ],
            // Thursday
            [
                'day_of_week' => 'thursday',
                'health_condition' => 'general',
                'title_en' => 'Weekend Eve Fiesta: Fuji Apple + Dragon Fruit + Pear',
                'title_bn' => 'বৃহস্পতিবারের উদযাপন: আপেল + ড্রাগন ফল + সবুজ নাশপাতি',
                'fruits_list' => [
                    ['fruit' => 'Fuji Apple', 'fruit_bn' => 'ফুজি আপেল', 'grams' => 50],
                    ['fruit' => 'Dragon Fruit', 'fruit_bn' => 'ড্রাগন ফল', 'grams' => 45],
                    ['fruit' => 'Green Pear', 'fruit_bn' => 'নাশপাতি', 'grams' => 45],
                ],
                'calories_total' => 76,
                'carbs_g' => 14.80,
                'fiber_g' => 3.70,
                'vitamins_focus' => 'Complete Antioxidant Shield',
                'dietitian_advice_en' => 'Finish the work week energized and ready to enjoy your weekend with family.',
                'dietitian_advice_bn' => 'সপ্তাহের শেষ কাজের দিনে ক্লান্তিহীনভাবে কাজ শেষ করার পুষ্টি উপাদান।',
                'is_active' => true,
            ]
        ];

        foreach ($dietitianMenus as $menu) {
            DietitianMenu::updateOrCreate(
                ['day_of_week' => $menu['day_of_week'], 'health_condition' => $menu['health_condition']],
                $menu
            );
        }

        // 5. Seed a Sample Active Subscription for Tanvir Ahmed
        $shaktiPkg = Package::where('code', 'shakti')->first();
        if ($shaktiPkg && $customer1) {
            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(28);

            $subscription = Subscription::updateOrCreate(
                ['subscription_code' => 'ND-SUB-2026-001'],
                [
                    'user_id' => $customer1->id,
                    'package_id' => $shaktiPkg->id,
                    'plan_duration' => '30_days',
                    'health_condition' => 'general',
                    'total_persons' => 1,
                    'daily_grams' => 130,
                    'delivery_office_name' => 'BrainStation 23 Ltd',
                    'delivery_office_address' => 'Plot 2, Block B, Mirpur DOHS, Dhaka',
                    'delivery_floor' => '4th Floor',
                    'delivery_desk' => 'Desk #42 (Dev Team)',
                    'delivery_phone' => '+8801811112233',
                    'delivery_time_slot' => '10:00 AM - 10:45 AM',
                    'delivery_days_type' => 'office_days_sun_thu',
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_delivery_days' => 22,
                    'delivered_days_count' => 3,
                    'paused_days_count' => 1,
                    'total_amount' => 1390.00,
                    'payment_status' => 'paid',
                    'subscription_status' => 'active',
                    'special_notes' => 'দয়া করে ডেস্কে পৌঁছে দিয়ে কল দিবেন।',
                ]
            );

            // Generate daily deliveries for the next 7 days
            for ($i = -2; $i <= 5; $i++) {
                $delivDate = Carbon::today()->addDays($i);
                $dayName = $delivDate->format('l');

                // Determine realistic statuses
                $status = 'scheduled';
                $deliveredAt = null;
                $deliveryBoy = 'Karim Rider';
                $pauseReason = null;

                if ($i < 0) {
                    $status = 'delivered';
                    $deliveredAt = $delivDate->copy()->setTime(10, 25);
                } elseif ($i == 0) {
                    $status = 'preparing';
                } elseif ($i == 2) {
                    // One day paused by user for vacation
                    $status = 'paused_by_user';
                    $pauseReason = 'অফিসে ছুটি / Annual Leave on Tuesday';
                }

                DailyDelivery::updateOrCreate(
                    [
                        'subscription_id' => $subscription->id,
                        'delivery_date' => $delivDate->toDateString(),
                    ],
                    [
                        'day_name' => $dayName,
                        'status' => $status,
                        'fruits_summary' => 'আপেল + পেয়ারা + ড্রাগন ফল (১৩০ গ্রাম বাউল)',
                        'delivery_person' => $deliveryBoy,
                        'delivered_at' => $deliveredAt,
                        'pause_reason' => $pauseReason,
                        'notes' => $i == 0 ? 'আজ সকাল ১০:৩০ মিনিটে ডেস্কে দিতে হবে' : null,
                    ]
                );
            }

            // Seed order for this subscription
            Order::updateOrCreate(
                ['order_number' => 'ND-ORD-2026-1001'],
                [
                    'user_id' => $customer1->id,
                    'subscription_id' => $subscription->id,
                    'package_id' => $shaktiPkg->id,
                    'order_type' => 'subscription',
                    'subtotal' => 1390.00,
                    'discount' => 0.00,
                    'total_amount' => 1390.00,
                    'payment_method' => 'bkash',
                    'payment_trx_id' => 'BKASH_TRX_' . strtoupper(Str::random(10)),
                    'payment_status' => 'paid',
                    'status' => 'active',
                    'customer_name' => $customer1->name,
                    'customer_email' => $customer1->email,
                    'customer_phone' => $customer1->phone,
                    'delivery_address' => 'BrainStation 23 Ltd, Floor 4, Mirpur DOHS, Dhaka',
                    'customer_notes' => '১ মাসের শক্তি প্যাক সাবস্ক্রিপশন',
                ]
            );
        }

        // 6. Seed a Corporate Subscription for Farhana Kabir
        $bondhuPkg = Package::where('code', 'bondhu')->first();
        if ($bondhuPkg && $customer2) {
            $sub2 = Subscription::updateOrCreate(
                ['subscription_code' => 'ND-SUB-2026-002'],
                [
                    'user_id' => $customer2->id,
                    'package_id' => $bondhuPkg->id,
                    'plan_duration' => '30_days',
                    'health_condition' => 'diabetes',
                    'total_persons' => 3,
                    'daily_grams' => 390,
                    'delivery_office_name' => 'Innovate FinTech Hub',
                    'delivery_office_address' => 'Tower 71, Karwan Bazar, Dhaka',
                    'delivery_floor' => '9th Floor',
                    'delivery_desk' => 'Cabin HR-02',
                    'delivery_phone' => '+8801922334455',
                    'delivery_time_slot' => '10:30 AM - 11:30 AM',
                    'delivery_days_type' => 'office_days_sun_thu',
                    'start_date' => Carbon::today(),
                    'end_date' => Carbon::today()->addDays(28),
                    'total_delivery_days' => 22,
                    'delivered_days_count' => 1,
                    'paused_days_count' => 0,
                    'total_amount' => 3790.00,
                    'payment_status' => 'paid',
                    'subscription_status' => 'active',
                    'special_notes' => 'ডায়াবেটিস রোগীদের জন্য বিশেষ কম মিষ্টি ফলের বাউল',
                ]
            );

            Order::updateOrCreate(
                ['order_number' => 'ND-ORD-2026-1002'],
                [
                    'user_id' => $customer2->id,
                    'subscription_id' => $sub2->id,
                    'package_id' => $bondhuPkg->id,
                    'order_type' => 'subscription',
                    'subtotal' => 3790.00,
                    'discount' => 0.00,
                    'total_amount' => 3790.00,
                    'payment_method' => 'card',
                    'payment_trx_id' => 'CARD_AUTH_' . strtoupper(Str::random(10)),
                    'payment_status' => 'paid',
                    'status' => 'active',
                    'customer_name' => $customer2->name,
                    'customer_email' => $customer2->email,
                    'customer_phone' => $customer2->phone,
                    'delivery_address' => 'Tower 71, 9th Floor, Karwan Bazar, Dhaka',
                    'customer_notes' => 'বন্ধু প্যাক (৩ জন) - ডায়াবেটিক স্পেশাল',
                ]
            );
        }
    }
}
