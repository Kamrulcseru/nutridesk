import React, { useState } from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, Alert } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';

export default function SubscriptionCalendarScreen({ lang, t }) {
    // Demo subscription state
    const [subStatus, setSubStatus] = useState({
        packageName: 'শক্তি প্যাকেজ (Shakti Solo)',
        condition: 'ডায়াবেটিস কেয়ার (Low-GI)',
        company: 'Tech Park BD',
        desk: '4th Floor, Desk #24',
        deliveredCount: 14,
        totalDays: 22,
        endDate: 'Nov 12, 2026',
    });

    const [daysList, setDaysList] = useState([
        { id: 1, date: 'Oct 18, 2026', dayName_bn: 'রবিবার', dayName_en: 'Sunday', status: 'delivered', time: '10:25 AM', fruit: 'ফুজি আপেল + থাই পেয়ারা' },
        { id: 2, date: 'Oct 19, 2026', dayName_bn: 'সোমবার', dayName_en: 'Monday', status: 'out_for_delivery', time: 'ডেস্কে আসছে', fruit: 'লাল ড্রাগন + পেঁপে' },
        { id: 3, date: 'Oct 20, 2026', dayName_bn: 'মঙ্গলবার', dayName_en: 'Tuesday', status: 'scheduled', time: '10:00 - 11:00 AM', fruit: 'বেদানা + মাল্টা + নাশপাতি' },
        { id: 4, date: 'Oct 21, 2026', dayName_bn: 'বুধবার', dayName_en: 'Wednesday', status: 'paused', time: 'দিন সংরক্ষিত', fruit: 'থাই পেয়ারা + মাল্টা' },
        { id: 5, date: 'Oct 22, 2026', dayName_bn: 'বৃহস্পতিবার', dayName_en: 'Thursday', status: 'scheduled', time: '10:00 - 11:00 AM', fruit: 'ফুজি আপেল + ড্রাগন ফল' },
    ]);

    const togglePause = (id) => {
        setDaysList((prev) =>
            prev.map((item) => {
                if (item.id === id) {
                    const isPaused = item.status === 'paused';
                    const newStatus = isPaused ? 'scheduled' : 'paused';

                    Alert.alert(
                        isPaused
                            ? (lang === 'bn' ? 'ডেলিভারি চালু করা হয়েছে' : 'Delivery Resumed')
                            : (lang === 'bn' ? 'ডেলিভারি পজ করা হয়েছে' : 'Delivery Paused'),
                        isPaused
                            ? (lang === 'bn' ? 'আপনার ডেস্কে নির্ধারিত দিনে ফ্রেশ ফল পৌঁছে যাবে।' : 'Fruit bowl will be delivered on schedule.')
                            : (lang === 'bn' ? 'এই দিনের জন্য আপনার টাকা বা ফল নষ্ট হবে না! আপনার সাবস্ক্রিপশন মেয়াদের শেষে ১টি অতিরিক্ত দিন যোগ হয়েছে।' : 'No fruit or money lost! 1 compensatory day added to end of subscription.')
                    );

                    return { ...item, status: newStatus };
                }
                return item;
            })
        );
    };

    const progressPercent = Math.round((subStatus.deliveredCount / subStatus.totalDays) * 100);

    return (
        <ScrollView style={styles.container} contentContainerStyle={styles.content} showsVerticalScrollIndicator={false}>
            {/* Active Subscription Summary Card */}
            <View style={styles.activeCard}>
                <View style={styles.activeHeader}>
                    <View style={styles.liveIndicator}>
                        <View style={styles.greenDot} />
                        <Text style={styles.liveText}>{lang === 'bn' ? 'সক্রিয় সাবস্ক্রিপশন' : 'ACTIVE SUBSCRIPTION'}</Text>
                    </View>
                    <Text style={styles.endDateText}>{lang === 'bn' ? 'মেয়াদ শেষ:' : 'Ends:'} {subStatus.endDate}</Text>
                </View>

                <Text style={styles.activePkgTitle}>{subStatus.packageName}</Text>
                <View style={styles.badgeRow}>
                    <View style={styles.conditionPill}>
                        <Ionicons name="medical" size={13} color="#059669" />
                        <Text style={styles.conditionPillText}>{subStatus.condition}</Text>
                    </View>
                    <View style={styles.deskPill}>
                        <Ionicons name="location" size={13} color={Colors.textSecondary} />
                        <Text style={styles.deskPillText}>{subStatus.desk}</Text>
                    </View>
                </View>

                {/* Progress bar */}
                <View style={styles.progressContainer}>
                    <View style={styles.progressHeader}>
                        <Text style={styles.progressLabel}>
                            {lang === 'bn' ? 'ডেলিভারি সম্পন্ন:' : 'Deliveries Done:'} {subStatus.deliveredCount} / {subStatus.totalDays} {t.days}
                        </Text>
                        <Text style={styles.progressPercent}>{progressPercent}%</Text>
                    </View>
                    <View style={styles.progressBarBg}>
                        <View style={[styles.progressBarFill, { width: `${progressPercent}%` }]} />
                    </View>
                </View>
            </View>

            {/* Smart Pause Policy Notice */}
            <View style={styles.pausePolicyNotice}>
                <Ionicons name="bulb" size={20} color="#D97706" />
                <View style={{ flex: 1 }}>
                    <Text style={styles.noticeTitle}>
                        {lang === 'bn' ? '১-ক্লিকে পজ / ছুটির সুবিধা' : '1-Click Pause & Skip Policy'}
                    </Text>
                    <Text style={styles.noticeText}>
                        {lang === 'bn'
                            ? 'অফিসে ছুটি থাকলে বা ট্যুরে গেলে ডেলিভারি পজ করুন। টাকা বা ফল নষ্ট হবে না, সমপরিমাণ দিন মেয়াদের শেষে স্বয়ংক্রিয়ভাবে যোগ হবে।'
                            : 'If on leave or out of office, pause your delivery anytime. Compensatory days are automatically added to the end of your plan.'}
                    </Text>
                </View>
            </View>

            {/* Schedule Calendar List */}
            <Text style={styles.sectionTitle}>
                {lang === 'bn' ? 'চলতি সপ্তাহের ডেলিভারি শিডিউল' : "This Week's Delivery Schedule"}
            </Text>

            {daysList.map((day) => {
                const isDelivered = day.status === 'delivered';
                const isOutForDelivery = day.status === 'out_for_delivery';
                const isPaused = day.status === 'paused';
                const isScheduled = day.status === 'scheduled';

                return (
                    <View key={day.id} style={[styles.dayItemCard, isPaused && styles.dayCardPaused]}>
                        <View style={styles.dayInfoLeft}>
                            <View style={styles.dayDateRow}>
                                <Text style={styles.dayName}>
                                    {lang === 'bn' ? day.dayName_bn : day.dayName_en}
                                </Text>
                                <Text style={styles.dayDate}>{day.date}</Text>
                            </View>

                            <Text style={styles.dayFruit}>{day.fruit}</Text>

                            <View style={styles.dayStatusRow}>
                                {isDelivered && (
                                    <View style={[styles.statusTag, { backgroundColor: '#D1FAE5' }]}>
                                        <Ionicons name="checkmark-circle" size={13} color="#059669" />
                                        <Text style={[styles.statusTagText, { color: '#065F46' }]}>
                                            {lang === 'bn' ? `ডেস্কে ডেলিভারি সম্পন্ন (${day.time})` : `Delivered at Desk (${day.time})`}
                                        </Text>
                                    </View>
                                )}
                                {isOutForDelivery && (
                                    <View style={[styles.statusTag, { backgroundColor: '#DBEAFE' }]}>
                                        <Ionicons name="bicycle" size={13} color="#2563EB" />
                                        <Text style={[styles.statusTagText, { color: '#1E40AF' }]}>
                                            {lang === 'bn' ? 'রাইডার ডেস্কে নিয়ে আসছে' : 'Out for Delivery'}
                                        </Text>
                                    </View>
                                )}
                                {isScheduled && (
                                    <View style={[styles.statusTag, { backgroundColor: '#F1F5F9' }]}>
                                        <Ionicons name="time" size={13} color={Colors.textSecondary} />
                                        <Text style={[styles.statusTagText, { color: Colors.textSecondary }]}>
                                            {lang === 'bn' ? `শিডিউল করা আছে (${day.time})` : `Scheduled (${day.time})`}
                                        </Text>
                                    </View>
                                )}
                                {isPaused && (
                                    <View style={[styles.statusTag, { backgroundColor: '#FEE2E2' }]}>
                                        <Ionicons name="pause-circle" size={13} color="#DC2626" />
                                        <Text style={[styles.statusTagText, { color: '#991B1B' }]}>
                                            {lang === 'bn' ? 'পজ করা (১ দিন পরবর্তীতে স্থানান্তরিত)' : 'Paused (Day Compensated)'}
                                        </Text>
                                    </View>
                                )}
                            </View>
                        </View>

                        {/* Action buttons (only for upcoming or paused days) */}
                        {(isScheduled || isPaused) && (
                            <TouchableOpacity
                                style={[styles.pauseBtn, isPaused ? styles.resumeBtn : styles.pauseBtnActive]}
                                onPress={() => togglePause(day.id)}
                            >
                                <Ionicons
                                    name={isPaused ? 'play' : 'pause'}
                                    size={14}
                                    color={isPaused ? '#FFFFFF' : '#DC2626'}
                                />
                                <Text style={[styles.pauseBtnText, isPaused ? { color: '#FFFFFF' } : { color: '#DC2626' }]}>
                                    {isPaused ? t.resumeDay : t.pauseDay}
                                </Text>
                            </TouchableOpacity>
                        )}
                    </View>
                );
            })}
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
    activeCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 18,
        borderWidth: 1,
        borderColor: Colors.border,
        marginBottom: 16,
    },
    activeHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 10,
    },
    liveIndicator: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
        backgroundColor: '#ECFDF5',
        paddingHorizontal: 8,
        paddingVertical: 4,
        borderRadius: 12,
    },
    greenDot: {
        width: 6,
        height: 6,
        borderRadius: 3,
        backgroundColor: Colors.primary,
    },
    liveText: {
        fontSize: 10,
        fontWeight: '800',
        color: Colors.primaryDark,
        letterSpacing: 0.5,
    },
    endDateText: {
        fontSize: 11,
        color: Colors.textMuted,
        fontWeight: '600',
    },
    activePkgTitle: {
        fontSize: 17,
        fontWeight: '800',
        color: Colors.text,
        marginBottom: 8,
    },
    badgeRow: {
        flexDirection: 'row',
        gap: 8,
        flexWrap: 'wrap',
        marginBottom: 16,
    },
    conditionPill: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        backgroundColor: Colors.primaryLight + '40',
        paddingHorizontal: 10,
        paddingVertical: 4,
        borderRadius: 10,
    },
    conditionPillText: {
        fontSize: 11,
        color: '#065F46',
        fontWeight: '700',
    },
    deskPill: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        backgroundColor: Colors.background,
        paddingHorizontal: 10,
        paddingVertical: 4,
        borderRadius: 10,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    deskPillText: {
        fontSize: 11,
        color: Colors.textSecondary,
        fontWeight: '600',
    },
    progressContainer: {
        borderTopWidth: 1,
        borderTopColor: Colors.border,
        paddingTop: 12,
    },
    progressHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginBottom: 6,
    },
    progressLabel: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.textSecondary,
    },
    progressPercent: {
        fontSize: 12,
        fontWeight: '800',
        color: Colors.primaryDark,
    },
    progressBarBg: {
        height: 8,
        backgroundColor: Colors.border,
        borderRadius: 4,
        overflow: 'hidden',
    },
    progressBarFill: {
        height: '100%',
        backgroundColor: Colors.primary,
        borderRadius: 4,
    },
    pausePolicyNotice: {
        flexDirection: 'row',
        backgroundColor: '#FFFBEB',
        borderRadius: 16,
        padding: 14,
        gap: 12,
        alignItems: 'flex-start',
        borderWidth: 1,
        borderColor: '#FDE68A',
        marginBottom: 18,
    },
    noticeTitle: {
        fontSize: 12,
        fontWeight: '800',
        color: '#92400E',
        marginBottom: 2,
    },
    noticeText: {
        fontSize: 11,
        color: '#B45309',
        lineHeight: 16,
    },
    sectionTitle: {
        fontSize: 13,
        fontWeight: '800',
        color: Colors.text,
        marginBottom: 10,
    },
    dayItemCard: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: '#FFFFFF',
        borderRadius: 16,
        padding: 14,
        marginBottom: 10,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    dayCardPaused: {
        backgroundColor: '#FFF5F5',
        borderColor: '#FECACA',
    },
    dayInfoLeft: {
        flex: 1,
        paddingRight: 12,
    },
    dayDateRow: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 8,
        marginBottom: 2,
    },
    dayName: {
        fontSize: 14,
        fontWeight: '800',
        color: Colors.text,
    },
    dayDate: {
        fontSize: 11,
        color: Colors.textMuted,
    },
    dayFruit: {
        fontSize: 12,
        color: Colors.textSecondary,
        fontWeight: '600',
        marginBottom: 6,
    },
    dayStatusRow: {
        flexDirection: 'row',
    },
    statusTag: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        paddingHorizontal: 8,
        paddingVertical: 3,
        borderRadius: 8,
    },
    statusTagText: {
        fontSize: 10,
        fontWeight: '700',
    },
    pauseBtn: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        paddingHorizontal: 10,
        paddingVertical: 6,
        borderRadius: 10,
    },
    pauseBtnActive: {
        backgroundColor: '#FEE2E2',
    },
    resumeBtn: {
        backgroundColor: Colors.primary,
    },
    pauseBtnText: {
        fontSize: 11,
        fontWeight: '800',
    },
});
