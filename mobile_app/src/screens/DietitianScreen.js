import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, RefreshControl } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';
import { ApiClient } from '../api/apiClient';

export default function DietitianScreen({ lang, t, onSubscribe }) {
    const [condition, setCondition] = useState('general');
    const [menu, setMenu] = useState([]);
    const [loading, setLoading] = useState(true);

    const loadMenu = async (cond) => {
        setLoading(true);
        const data = await ApiClient.getDietitianMenu(cond);
        setMenu(data);
        setLoading(false);
    };

    useEffect(() => {
        loadMenu(condition);
    }, [condition]);

    const conditionsList = [
        { key: 'general', label_bn: 'সাধারণ স্বাস্থ্য', label_en: 'General Health', icon: 'nutrition' },
        { key: 'diabetes', label_bn: 'ডায়াবেটিস (Low-GI)', label_en: 'Diabetes Care', icon: 'water' },
        { key: 'kidney', label_bn: 'কিডনি যত্ন', label_en: 'Kidney Friendly', icon: 'pulse' },
        { key: 'heart', label_bn: 'হার্ট ও প্রেশার', label_en: 'Heart Care', icon: 'heart' },
    ];

    return (
        <ScrollView
            style={styles.container}
            contentContainerStyle={styles.content}
            showsVerticalScrollIndicator={false}
            refreshControl={<RefreshControl refreshing={loading} onRefresh={() => loadMenu(condition)} colors={[Colors.primary]} />}
        >
            {/* Dietitian Header Card */}
            <View style={styles.dietitianProfileCard}>
                <View style={styles.avatarBox}>
                    <Ionicons name="medical" size={24} color={Colors.primary} />
                </View>
                <View style={styles.profileText}>
                    <Text style={styles.doctorRole}>
                        {lang === 'bn' ? 'প্রধান পুষ্টিবিদ ও ডায়েট কনসালটেন্ট' : 'Chief Clinical Nutritionist'}
                    </Text>
                    <Text style={styles.doctorName}>Dr. Farzana Ahmed (M.Phil)</Text>
                    <Text style={styles.doctorDegree}>
                        {lang === 'bn' ? 'এক্সপার্ট ইন কর্পোরেট ওয়েলনেস ও ক্লিনিক্যাল নিউট্রিশন' : 'Specialist in Corporate Energy & Dietary Health'}
                    </Text>
                </View>
            </View>

            {/* Health Condition Filters */}
            <View style={styles.filterSection}>
                <Text style={styles.filterTitle}>
                    {lang === 'bn' ? 'স্বাস্থ্য অনুযায়ী মেনু ফিল্টার করুন:' : 'Filter Menu by Health Profile:'}
                </Text>
                <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.filterRow}>
                    {conditionsList.map((item) => {
                        const active = condition === item.key;
                        return (
                            <TouchableOpacity
                                key={item.key}
                                style={[styles.filterChip, active && styles.filterChipActive]}
                                onPress={() => setCondition(item.key)}
                            >
                                <Ionicons name={item.icon} size={15} color={active ? '#FFFFFF' : Colors.textSecondary} />
                                <Text style={[styles.filterChipText, active && styles.filterChipTextActive]}>
                                    {lang === 'bn' ? item.label_bn : item.label_en}
                                </Text>
                            </TouchableOpacity>
                        );
                    })}
                </ScrollView>
            </View>

            {/* Condition Info Banner */}
            <View style={styles.conditionBanner}>
                <Ionicons name="information-circle" size={18} color={Colors.primaryDark} />
                <Text style={styles.conditionBannerText}>
                    {condition === 'general' && (lang === 'bn' ? 'সকল সাধারণ সুস্থ অফিস কর্মীদের জন্য বৈচিত্র্যময় ৫ দিনের এনার্জি মেনু।' : '5-day balanced antioxidant and vitamin booster schedule.')}
                    {condition === 'diabetes' && (lang === 'bn' ? 'কম গ্লাইসেমিক ইনডেক্স (Low-GI) ফল - রক্তের সুগার স্পাইক করবে না, দীর্ঘক্ষণ শক্তি দিবে।' : 'Low-GI fruits that maintain steady blood glucose levels with zero spike.')}
                    {condition === 'kidney' && (lang === 'bn' ? 'কম পটাশিয়াম ও কম ফসফরাসযুক্ত ফল - কিডনি রোগীদের জন্য নিরাপদ ও পুষ্টিকর।' : 'Low-potassium and renal-friendly portion-controlled fruits.')}
                    {condition === 'heart' && (lang === 'bn' ? 'উচ্চ ফাইবার এবং পলিফেনল সমৃদ্ধ ফল - রক্তচাপ নিয়ন্ত্রণে সাহায্য করে।' : 'Heart-healthy polyphenol rich fruits that promote healthy circulation.')}
                </Text>
            </View>

            {/* Weekly Days List */}
            {menu.map((item, idx) => (
                <View key={item.id || idx} style={styles.dayCard}>
                    <View style={styles.dayHeader}>
                        <View style={styles.dayBadge}>
                            <Ionicons name="calendar" size={14} color={Colors.primaryDark} />
                            <Text style={styles.dayBadgeText}>{item.day}</Text>
                        </View>
                        <View style={styles.calorieBadge}>
                            <Text style={styles.calorieText}>{item.calories} kcal</Text>
                        </View>
                    </View>

                    <Text style={styles.fruitComboTitle}>
                        {lang === 'bn' ? item.title_bn : item.title_en}
                    </Text>

                    {/* Nutrients Pills */}
                    <View style={styles.nutrientsRow}>
                        <View style={styles.nutrientPill}>
                            <Text style={styles.nutrientLabel}>কার্বোহাইড্রেট</Text>
                            <Text style={styles.nutrientVal}>{item.carbs}</Text>
                        </View>
                        <View style={styles.nutrientPill}>
                            <Text style={styles.nutrientLabel}>ফাইবার</Text>
                            <Text style={styles.nutrientVal}>{item.fiber}</Text>
                        </View>
                        <View style={[styles.nutrientPill, { flex: 1.4 }]}>
                            <Text style={styles.nutrientLabel}>প্রধান পুষ্টি</Text>
                            <Text style={styles.nutrientVal} numberOfLines={1}>{item.vitamins}</Text>
                        </View>
                    </View>

                    {/* Nutritionist Note */}
                    <View style={styles.noteBox}>
                        <Ionicons name="bulb-outline" size={16} color="#D97706" style={{ marginTop: 2 }} />
                        <Text style={styles.noteText}>
                            {lang === 'bn' ? item.note_bn : item.note_en}
                        </Text>
                    </View>
                </View>
            ))}

            {/* CTA */}
            <TouchableOpacity style={styles.ctaBtn} onPress={onSubscribe}>
                <Ionicons name="flash" size={18} color="#FFFFFF" />
                <Text style={styles.ctaBtnText}>
                    {lang === 'bn' ? 'এই ডায়েট প্ল্যানে সাবস্ক্রাইব করুন' : 'Subscribe to This Diet Plan'}
                </Text>
            </TouchableOpacity>
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
    dietitianProfileCard: {
        flexDirection: 'row',
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 16,
        alignItems: 'center',
        gap: 14,
        borderWidth: 1,
        borderColor: Colors.border,
        marginBottom: 16,
    },
    avatarBox: {
        width: 48,
        height: 48,
        borderRadius: 24,
        backgroundColor: Colors.primaryLight,
        justifyContent: 'center',
        alignItems: 'center',
    },
    profileText: {
        flex: 1,
    },
    doctorRole: {
        fontSize: 10,
        fontWeight: '800',
        color: Colors.primaryDark,
        textTransform: 'uppercase',
    },
    doctorName: {
        fontSize: 15,
        fontWeight: '800',
        color: Colors.text,
        marginTop: 2,
    },
    doctorDegree: {
        fontSize: 11,
        color: Colors.textSecondary,
        marginTop: 2,
    },
    filterSection: {
        marginBottom: 14,
    },
    filterTitle: {
        fontSize: 12,
        fontWeight: '700',
        color: Colors.textSecondary,
        marginBottom: 8,
    },
    filterRow: {
        gap: 8,
    },
    filterChip: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
        paddingHorizontal: 14,
        paddingVertical: 8,
        borderRadius: 20,
        backgroundColor: '#FFFFFF',
        borderWidth: 1,
        borderColor: Colors.border,
    },
    filterChipActive: {
        backgroundColor: Colors.primary,
        borderColor: Colors.primary,
    },
    filterChipText: {
        fontSize: 12,
        fontWeight: '700',
        color: Colors.textSecondary,
    },
    filterChipTextActive: {
        color: '#FFFFFF',
    },
    conditionBanner: {
        flexDirection: 'row',
        backgroundColor: Colors.primaryLight + '40',
        borderWidth: 1,
        borderColor: Colors.primaryLight,
        borderRadius: 14,
        padding: 12,
        gap: 8,
        alignItems: 'center',
        marginBottom: 16,
    },
    conditionBannerText: {
        flex: 1,
        fontSize: 11,
        color: '#065F46',
        lineHeight: 16,
        fontWeight: '600',
    },
    dayCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 18,
        padding: 16,
        marginBottom: 14,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    dayHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 10,
    },
    dayBadge: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
        backgroundColor: Colors.background,
        paddingHorizontal: 10,
        paddingVertical: 4,
        borderRadius: 10,
    },
    dayBadgeText: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.primaryDark,
    },
    calorieBadge: {
        backgroundColor: '#FEF3C7',
        paddingHorizontal: 8,
        paddingVertical: 3,
        borderRadius: 8,
    },
    calorieText: {
        fontSize: 11,
        fontWeight: '800',
        color: '#92400E',
    },
    fruitComboTitle: {
        fontSize: 15,
        fontWeight: '800',
        color: Colors.text,
        marginBottom: 12,
    },
    nutrientsRow: {
        flexDirection: 'row',
        gap: 8,
        marginBottom: 12,
    },
    nutrientPill: {
        flex: 1,
        backgroundColor: Colors.background,
        paddingVertical: 6,
        paddingHorizontal: 8,
        borderRadius: 10,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    nutrientLabel: {
        fontSize: 9,
        fontWeight: '700',
        color: Colors.textMuted,
    },
    nutrientVal: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.text,
        marginTop: 2,
    },
    noteBox: {
        flexDirection: 'row',
        backgroundColor: '#FFFBEB',
        padding: 10,
        borderRadius: 10,
        gap: 8,
        alignItems: 'flex-start',
    },
    noteText: {
        flex: 1,
        fontSize: 11,
        color: '#B45309',
        lineHeight: 16,
    },
    ctaBtn: {
        flexDirection: 'row',
        backgroundColor: Colors.primary,
        paddingVertical: 14,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
        gap: 8,
        marginTop: 6,
        shadowColor: Colors.primary,
        shadowOpacity: 0.3,
        shadowRadius: 8,
        elevation: 4,
    },
    ctaBtnText: {
        color: '#FFFFFF',
        fontSize: 14,
        fontWeight: '800',
    },
});
