import React, { useState } from 'react';
import { StyleSheet, Text, View, SafeAreaView, TouchableOpacity, Alert, Platform, StatusBar } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from './src/constants/colors';
import { Translations } from './src/constants/translations';
import PackagesScreen from './src/screens/PackagesScreen';
import DietitianScreen from './src/screens/DietitianScreen';
import HealthCareScreen from './src/screens/HealthCareScreen';
import SubscriptionCalendarScreen from './src/screens/SubscriptionCalendarScreen';
import ProfileOrdersScreen from './src/screens/ProfileOrdersScreen';
import CheckoutModal from './src/components/CheckoutModal';
import BkashModal from './src/components/BkashModal';

export default function App() {
    const [lang, setLang] = useState('bn');
    const [activeTab, setActiveTab] = useState('packages'); // packages, dietitian, healthcare, calendar, profile

    // Modals
    const [checkoutVisible, setCheckoutVisible] = useState(false);
    const [selectedPackage, setSelectedPackage] = useState(null);
    const [bkashVisible, setBkashVisible] = useState(false);
    const [orderSummary, setOrderSummary] = useState(null);

    const t = Translations[lang];

    const toggleLang = () => {
        setLang((prev) => (prev === 'bn' ? 'en' : 'bn'));
    };

    // Open checkout from package selection
    const handleSelectPackage = (pkg, duration = '30_days') => {
        setSelectedPackage({
            ...pkg,
            min_persons: pkg.code === 'shakti' ? 1 : pkg.code === 'bondhu' ? 2 : 5,
            max_persons: pkg.code === 'shakti' ? 1 : pkg.code === 'bondhu' ? 4 : 20,
        });
        setCheckoutVisible(true);
    };

    // Open checkout from Dietitian screen
    const handleSubscribeFromDietitian = () => {
        handleSelectPackage({
            id: 1,
            code: 'shakti',
            name_bn: 'শক্তি প্যাকেজ (১ জনের জন্য)',
            name_en: 'Shakti Solo Pack (1 Person)',
            grams_per_person_daily: 120,
            price_7_days: 450,
            price_30_days: 1390,
            price_per_person_per_day: 63,
            min_persons: 1,
            max_persons: 1,
        });
    };

    // Open checkout from Health Care screen
    const handleSelectCondition = (conditionKey) => {
        handleSelectPackage({
            id: 1,
            code: 'shakti',
            name_bn: 'শক্তি প্যাকেজ (১ জনের জন্য)',
            name_en: 'Shakti Solo Pack (1 Person)',
            grams_per_person_daily: 120,
            price_7_days: 450,
            price_30_days: 1390,
            price_per_person_per_day: 63,
            min_persons: 1,
            max_persons: 1,
        });
    };

    // Process proceed from Checkout Modal
    const handleProceedToPayment = (orderData) => {
        setCheckoutVisible(false);
        setOrderSummary(orderData);

        if (orderData.paymentMethod === 'bkash') {
            setBkashVisible(true);
        } else {
            handleOrderSuccess(orderData);
        }
    };

    // Successful payment completion
    const handleOrderSuccess = (orderData = orderSummary) => {
        setBkashVisible(false);
        const orderId = 'ND-' + Math.floor(100000 + Math.random() * 900000);

        Alert.alert(
            lang === 'bn' ? '🎉 অভিনন্দন! সাবস্ক্রিপশন সম্পন্ন' : '🎉 Subscription Confirmed!',
            lang === 'bn'
                ? `আপনার অর্ডার #${orderId} সফলভাবে গ্রহণ করা হয়েছে!\n\n` +
                  `প্যাকেজ: ${orderData?.packageData?.name_bn || 'শক্তি প্যাকেজ'}\n` +
                  `ডেলিভারি ডেস্কে: ${orderData?.officeName || 'অফিস'}, ${orderData?.deskNumber || 'ডেস্ক'}\n` +
                  `ডেলিভারি সময়: সকাল ৯:৩০ - ১১:০০\n\n` +
                  `আপনার মোবাইলে এসএমএস কনফার্মেশন পাঠানো হয়েছে।`
                : `Order #${orderId} is confirmed!\n\n` +
                  `Portions will be delivered to: ${orderData?.officeName || 'Office'}, ${orderData?.deskNumber || 'Desk'}\n` +
                  `Slot: 09:30 - 11:00 AM\n\n` +
                  `SMS confirmation has been dispatched to your mobile.`,
            [
                {
                    text: lang === 'bn' ? 'আমার শিডিউল দেখুন' : 'View My Schedule',
                    onPress: () => setActiveTab('calendar'),
                },
            ]
        );
    };

    const navTabs = [
        { key: 'packages', title: t.tabPackages, icon: 'basket' },
        { key: 'dietitian', title: t.tabMenu, icon: 'nutrition' },
        { key: 'healthcare', title: t.tabHealth, icon: 'heart-circle' },
        { key: 'calendar', title: t.tabCalendar, icon: 'calendar' },
        { key: 'profile', title: t.tabProfile, icon: 'person-circle' },
    ];

    return (
        <SafeAreaView style={styles.safeArea}>
            <StatusBar barStyle="dark-content" backgroundColor="#FFFFFF" />

            {/* Top Bar Header */}
            <View style={styles.header}>
                <View style={styles.logoRow}>
                    <View style={styles.logoIcon}>
                        <Ionicons name="leaf" size={18} color="#FFFFFF" />
                    </View>
                    <View>
                        <View style={styles.titleWithBadge}>
                            <Text style={styles.brandTitle}>NutriDesk</Text>
                            <View style={styles.proBadge}>
                                <Text style={styles.proBadgeText}>PRO</Text>
                            </View>
                        </View>
                        <Text style={styles.brandTagline}>{t.tagline}</Text>
                    </View>
                </View>

                {/* Right Header Actions */}
                <View style={styles.headerRight}>
                    <TouchableOpacity style={styles.langToggleBtn} onPress={toggleLang}>
                        <Ionicons name="globe-outline" size={14} color={Colors.primaryDark} />
                        <Text style={styles.langToggleText}>{lang === 'bn' ? 'English' : 'বাংলা'}</Text>
                    </TouchableOpacity>
                </View>
            </View>

            {/* Main Screen Content */}
            <View style={styles.mainContainer}>
                {activeTab === 'packages' && (
                    <PackagesScreen lang={lang} t={t} onSelectPackage={handleSelectPackage} />
                )}
                {activeTab === 'dietitian' && (
                    <DietitianScreen lang={lang} t={t} onSubscribe={handleSubscribeFromDietitian} />
                )}
                {activeTab === 'healthcare' && (
                    <HealthCareScreen lang={lang} t={t} onSelectCondition={handleSelectCondition} />
                )}
                {activeTab === 'calendar' && (
                    <SubscriptionCalendarScreen lang={lang} t={t} />
                )}
                {activeTab === 'profile' && (
                    <ProfileOrdersScreen lang={lang} t={t} onToggleLang={toggleLang} />
                )}
            </View>

            {/* Bottom Tab Navigation */}
            <View style={styles.bottomNav}>
                {navTabs.map((tab) => {
                    const isActive = activeTab === tab.key;
                    return (
                        <TouchableOpacity
                            key={tab.key}
                            style={styles.navItem}
                            onPress={() => setActiveTab(tab.key)}
                        >
                            <Ionicons
                                name={isActive ? tab.icon : `${tab.icon}-outline`}
                                size={22}
                                color={isActive ? Colors.primary : Colors.textMuted}
                            />
                            <Text style={[styles.navText, isActive && styles.navTextActive]}>
                                {tab.title}
                            </Text>
                        </TouchableOpacity>
                    );
                })}
            </View>

            {/* Checkout Modal */}
            <CheckoutModal
                visible={checkoutVisible}
                packageData={selectedPackage}
                onClose={() => setCheckoutVisible(false)}
                onProceedToPayment={handleProceedToPayment}
                lang={lang}
                t={t}
            />

            {/* bKash Payment Simulation Modal */}
            <BkashModal
                visible={bkashVisible}
                orderData={orderSummary}
                onClose={() => setBkashVisible(false)}
                onSuccess={() => handleOrderSuccess(orderSummary)}
            />
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    safeArea: {
        flex: 1,
        backgroundColor: '#FFFFFF',
        paddingTop: Platform.OS === 'android' ? StatusBar.currentHeight : 0,
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        paddingHorizontal: 16,
        paddingVertical: 12,
        backgroundColor: '#FFFFFF',
        borderBottomWidth: 1,
        borderBottomColor: Colors.border,
    },
    logoRow: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 10,
    },
    logoIcon: {
        width: 36,
        height: 36,
        borderRadius: 10,
        backgroundColor: Colors.primary,
        justifyContent: 'center',
        alignItems: 'center',
        shadowColor: Colors.primary,
        shadowOpacity: 0.3,
        shadowRadius: 6,
        elevation: 3,
    },
    titleWithBadge: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
    },
    brandTitle: {
        fontSize: 17,
        fontWeight: '900',
        color: Colors.text,
        letterSpacing: -0.3,
    },
    proBadge: {
        backgroundColor: '#DCFCE7',
        paddingHorizontal: 5,
        paddingVertical: 2,
        borderRadius: 6,
    },
    proBadgeText: {
        fontSize: 9,
        fontWeight: '800',
        color: '#15803D',
    },
    brandTagline: {
        fontSize: 10,
        color: Colors.textSecondary,
        fontWeight: '600',
        marginTop: 1,
    },
    headerRight: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 8,
    },
    langToggleBtn: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        backgroundColor: Colors.primaryLight + '50',
        paddingHorizontal: 10,
        paddingVertical: 6,
        borderRadius: 20,
        borderWidth: 1,
        borderColor: Colors.primaryLight,
    },
    langToggleText: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.primaryDark,
    },
    mainContainer: {
        flex: 1,
    },
    bottomNav: {
        flexDirection: 'row',
        backgroundColor: '#FFFFFF',
        borderTopWidth: 1,
        borderTopColor: Colors.border,
        paddingVertical: 8,
        paddingBottom: Platform.OS === 'ios' ? 24 : 10,
        shadowColor: '#000',
        shadowOpacity: 0.05,
        shadowRadius: 10,
        elevation: 10,
    },
    navItem: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
    },
    navText: {
        fontSize: 10,
        fontWeight: '600',
        color: Colors.textMuted,
        marginTop: 3,
    },
    navTextActive: {
        color: Colors.primary,
        fontWeight: '800',
    },
});
