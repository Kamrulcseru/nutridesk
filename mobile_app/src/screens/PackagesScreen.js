import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, RefreshControl } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';
import { ApiClient } from '../api/apiClient';

export default function PackagesScreen({ lang, t, onSelectPackage }) {
    const [packages, setPackages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedDuration, setSelectedDuration] = useState('30_days'); // '7_days' or '30_days'

    const loadPackages = async () => {
        setLoading(true);
        const data = await ApiClient.getPackages();
        setPackages(data);
        setLoading(false);
    };

    useEffect(() => {
        loadPackages();
    }, []);

    return (
        <ScrollView
            style={styles.container}
            contentContainerStyle={styles.content}
            showsVerticalScrollIndicator={false}
            refreshControl={<RefreshControl refreshing={loading} onRefresh={loadPackages} colors={[Colors.primary]} />}
        >
            {/* Hero Banner */}
            <View style={styles.heroCard}>
                <View style={styles.heroBadge}>
                    <Ionicons name="sparkles" size={14} color="#059669" />
                    <Text style={styles.heroBadgeText}>{lang === 'bn' ? 'অফিস হেলথ রিভোলিউশন' : 'Office Wellness'}</Text>
                </View>
                <Text style={styles.heroTitle}>{t.heroTitle}</Text>
                <Text style={styles.heroSub}>{t.heroSub}</Text>

                <View style={styles.heroStatsRow}>
                    <View style={styles.heroStatItem}>
                        <Text style={styles.heroStatVal}>১০০-১৫০g</Text>
                        <Text style={styles.heroStatLbl}>{lang === 'bn' ? 'দৈনিক কাটা ফল' : 'Daily Portion'}</Text>
                    </View>
                    <View style={styles.heroStatDivider} />
                    <View style={styles.heroStatItem}>
                        <Text style={styles.heroStatVal}>Food-Grade</Text>
                        <Text style={styles.heroStatLbl}>{lang === 'bn' ? 'হাইজিনিক বাউল' : 'Clean Bowls'}</Text>
                    </View>
                    <View style={styles.heroStatDivider} />
                    <View style={styles.heroStatItem}>
                        <Text style={styles.heroStatVal}>&lt; ১১:০০ AM</Text>
                        <Text style={styles.heroStatLbl}>{lang === 'bn' ? 'ডেস্কে ডেলিভারি' : 'Desk Delivery'}</Text>
                    </View>
                </View>
            </View>

            {/* Duration Switcher */}
            <View style={styles.durationSelectorWrapper}>
                <Text style={styles.durationLabel}>
                    {lang === 'bn' ? 'প্যাকেজের মেয়াদ নির্বাচন করুন:' : 'Select Duration:'}
                </Text>
                <View style={styles.durationTabs}>
                    <TouchableOpacity
                        style={[styles.durationTab, selectedDuration === '7_days' && styles.durationTabActive]}
                        onPress={() => setSelectedDuration('7_days')}
                    >
                        <Text style={[styles.durationTabText, selectedDuration === '7_days' && styles.durationTabTextActive]}>
                            {t.trialDuration} (৫ কর্মদিবস)
                        </Text>
                    </TouchableOpacity>

                    <TouchableOpacity
                        style={[styles.durationTab, selectedDuration === '30_days' && styles.durationTabActive]}
                        onPress={() => setSelectedDuration('30_days')}
                    >
                        <Text style={[styles.durationTabText, selectedDuration === '30_days' && styles.durationTabTextActive]}>
                            {t.monthlyDuration} (২২ কর্মদিবস)
                        </Text>
                    </TouchableOpacity>
                </View>
            </View>

            {/* Package Cards List */}
            {packages.map((pkg) => {
                const price = selectedDuration === '7_days' ? pkg.price_7_days : pkg.price_30_days;
                const days = selectedDuration === '7_days' ? 5 : 22;
                const dailyCost = Math.round(price / days);

                return (
                    <View key={pkg.id} style={styles.packageCard}>
                        {pkg.badge_text && (
                            <View style={styles.badgeWrapper}>
                                <Text style={styles.badgeText}>{pkg.badge_text}</Text>
                            </View>
                        )}

                        <View style={styles.pkgHeader}>
                            <View>
                                <Text style={styles.pkgTitle}>
                                    {lang === 'bn' ? pkg.name_bn : pkg.name_en}
                                </Text>
                                <Text style={styles.pkgDesc}>
                                    {lang === 'bn' ? pkg.description_bn : pkg.description_en}
                                </Text>
                            </View>
                        </View>

                        {/* Pricing Block */}
                        <View style={styles.priceContainer}>
                            <View>
                                <Text style={styles.priceCurrency}>
                                    <Text style={styles.priceVal}>৳{price.toLocaleString()}</Text>
                                    <Text style={styles.pricePeriod}> / {selectedDuration === '7_days' ? (lang === 'bn' ? '৭ দিন' : '7 days') : (lang === 'bn' ? '১ মাস' : '1 month')}</Text>
                                </Text>
                                <Text style={styles.dailyCalculation}>
                                    {t.perDay} ৳{dailyCost} ({pkg.grams_per_person_daily}g {t.grams})
                                </Text>
                            </View>

                            <TouchableOpacity
                                style={styles.orderBtn}
                                onPress={() => onSelectPackage(pkg, selectedDuration)}
                            >
                                <Text style={styles.orderBtnText}>{t.subscribeNow}</Text>
                                <Ionicons name="arrow-forward" size={16} color="#FFFFFF" />
                            </TouchableOpacity>
                        </View>

                        {/* Feature Checklist */}
                        <View style={styles.featuresList}>
                            {(lang === 'bn' ? pkg.features_bn : pkg.features_en).map((feat, idx) => (
                                <View key={idx} style={styles.featureItem}>
                                    <Ionicons name="checkmark-circle" size={16} color={Colors.primary} />
                                    <Text style={styles.featureText}>{feat}</Text>
                                </View>
                            ))}
                        </View>
                    </View>
                );
            })}

            {/* Why NutriDesk Info Box */}
            <View style={styles.infoBox}>
                <Ionicons name="shield-checkmark" size={24} color={Colors.primary} />
                <View style={styles.infoContent}>
                    <Text style={styles.infoTitle}>
                        {lang === 'bn' ? '১০০% হাইজিনিক ও ওজোন ওয়াশ' : '100% Hygienic Ozone Washed'}
                    </Text>
                    <Text style={styles.infoText}>
                        {lang === 'bn'
                            ? 'আমাদের প্রতিটি ফল ওজোন প্রযুক্তি দিয়ে জীবানুমুক্ত করে ফুড-গ্রেড বক্সে প্রিপেয়ার করা হয়। ছুটির দিনে নোটিফিকেশন ছাড়াই এক ক্লিকে পজ করা যায়।'
                            : 'Every fruit is ozone cleaned, peeled and packed in food-grade eco containers. 1-click pause delivery anytime.'}
                    </Text>
                </View>
            </View>
        </ScrollView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    content: {
        padding: 16,
        paddingBottom: 40,
    },
    heroCard: {
        backgroundColor: '#064E3B',
        borderRadius: 20,
        padding: 20,
        marginBottom: 18,
    },
    heroBadge: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: '#D1FAE5',
        alignSelf: 'flex-start',
        paddingHorizontal: 10,
        paddingVertical: 4,
        borderRadius: 20,
        gap: 6,
        marginBottom: 10,
    },
    heroBadgeText: {
        fontSize: 11,
        fontWeight: '700',
        color: '#065F46',
    },
    heroTitle: {
        fontSize: 20,
        fontWeight: '900',
        color: '#FFFFFF',
        lineHeight: 28,
        marginBottom: 6,
    },
    heroSub: {
        fontSize: 12,
        color: '#A7F3D0',
        lineHeight: 18,
        marginBottom: 16,
    },
    heroStatsRow: {
        flexDirection: 'row',
        backgroundColor: 'rgba(255,255,255,0.1)',
        borderRadius: 14,
        paddingVertical: 12,
        paddingHorizontal: 10,
        justifyContent: 'space-around',
        alignItems: 'center',
    },
    heroStatItem: {
        alignItems: 'center',
    },
    heroStatVal: {
        color: '#FFFFFF',
        fontSize: 14,
        fontWeight: '800',
    },
    heroStatLbl: {
        color: '#A7F3D0',
        fontSize: 10,
        marginTop: 2,
    },
    heroStatDivider: {
        width: 1,
        height: 24,
        backgroundColor: 'rgba(255,255,255,0.2)',
    },
    durationSelectorWrapper: {
        marginBottom: 16,
    },
    durationLabel: {
        fontSize: 12,
        fontWeight: '700',
        color: Colors.textSecondary,
        marginBottom: 8,
    },
    durationTabs: {
        flexDirection: 'row',
        backgroundColor: Colors.border,
        borderRadius: 14,
        padding: 4,
        gap: 4,
    },
    durationTab: {
        flex: 1,
        paddingVertical: 10,
        alignItems: 'center',
        borderRadius: 10,
    },
    durationTabActive: {
        backgroundColor: '#FFFFFF',
        shadowColor: '#000',
        shadowOpacity: 0.05,
        shadowRadius: 4,
        elevation: 2,
    },
    durationTabText: {
        fontSize: 12,
        fontWeight: '600',
        color: Colors.textMuted,
    },
    durationTabTextActive: {
        color: Colors.primaryDark,
        fontWeight: '800',
    },
    packageCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 18,
        marginBottom: 16,
        borderWidth: 1,
        borderColor: Colors.border,
        shadowColor: '#000',
        shadowOpacity: 0.04,
        shadowRadius: 8,
        elevation: 2,
        position: 'relative',
    },
    badgeWrapper: {
        position: 'absolute',
        top: -10,
        right: 18,
        backgroundColor: Colors.secondary,
        paddingHorizontal: 12,
        paddingVertical: 4,
        borderRadius: 12,
    },
    badgeText: {
        color: '#FFFFFF',
        fontSize: 10,
        fontWeight: '800',
    },
    pkgHeader: {
        marginBottom: 12,
    },
    pkgTitle: {
        fontSize: 17,
        fontWeight: '800',
        color: Colors.text,
        marginBottom: 4,
    },
    pkgDesc: {
        fontSize: 12,
        color: Colors.textSecondary,
        lineHeight: 18,
    },
    priceContainer: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: Colors.background,
        padding: 12,
        borderRadius: 14,
        marginBottom: 14,
    },
    priceCurrency: {
        flexDirection: 'row',
        alignItems: 'baseline',
    },
    priceVal: {
        fontSize: 22,
        fontWeight: '900',
        color: Colors.text,
    },
    pricePeriod: {
        fontSize: 12,
        color: Colors.textMuted,
    },
    dailyCalculation: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.primaryDark,
        marginTop: 2,
    },
    orderBtn: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.primary,
        paddingHorizontal: 16,
        paddingVertical: 10,
        borderRadius: 12,
        gap: 6,
    },
    orderBtnText: {
        color: '#FFFFFF',
        fontSize: 13,
        fontWeight: '800',
    },
    featuresList: {
        gap: 8,
        borderTopWidth: 1,
        borderTopColor: Colors.border,
        paddingTop: 12,
    },
    featureItem: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 8,
    },
    featureText: {
        fontSize: 12,
        color: Colors.textSecondary,
        flex: 1,
    },
    infoBox: {
        flexDirection: 'row',
        backgroundColor: '#ECFDF5',
        borderRadius: 16,
        padding: 16,
        gap: 12,
        alignItems: 'flex-start',
        borderWidth: 1,
        borderColor: '#A7F3D0',
        marginTop: 4,
    },
    infoContent: {
        flex: 1,
    },
    infoTitle: {
        fontSize: 13,
        fontWeight: '800',
        color: '#065F46',
        marginBottom: 4,
    },
    infoText: {
        fontSize: 11,
        color: '#047857',
        lineHeight: 16,
    },
});
