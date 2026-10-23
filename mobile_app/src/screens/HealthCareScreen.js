import React from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';

export default function HealthCareScreen({ lang, t, onSelectCondition }) {
    const healthCategories = [
        {
            key: 'diabetes',
            title_bn: 'ডায়াবেটিস কেয়ার (Low-GI)',
            title_en: 'Diabetes Care (Low Glycemic Index)',
            color: '#059669',
            lightColor: '#D1FAE5',
            icon: 'water',
            desc_bn: 'রক্তের সুগার স্পাইক নিয়ন্ত্রণ করে এবং সারাদিন দীর্ঘস্থায়ী এনার্জি বজায় রাখে।',
            desc_en: 'Prevents blood glucose spikes while sustaining steady office mental energy.',
            allowed_bn: ['সবুজ/ফুজি আপেল', 'থাই পেয়ারা (ভিটামিন C সমৃদ্ধ)', 'কাঁচা-মিঠা পেঁপে', 'ব্ল্যাকবেরি ও জাম'],
            allowed_en: ['Fuji / Green Apple', 'Thai Guava', 'Half-ripe Papaya', 'Berries'],
            restricted_bn: 'আম, কাঁঠাল, বা অতিরিক্ত মিষ্টি পাকা কলা বর্জন করা হয়।',
            restricted_en: 'Avoids overly sweet mangoes, jackfruits, or high sugar syrups.',
        },
        {
            key: 'kidney',
            title_bn: 'কিডনি স্বাস্থ্য রক্ষা (Low-Potassium)',
            title_en: 'Kidney Friendly (Renal Care)',
            color: '#2563EB',
            lightColor: '#DBEAFE',
            icon: 'pulse',
            desc_bn: 'কিডনির ফিল্ট্রেশন ক্ষমতার উপর চাপ না ফেলে প্রাত্যহিক ভিটামিন ও হাইড্রেশন নিশ্চিত করে।',
            desc_en: 'Provides essential vitamins and hydration without taxing renal filtration.',
            allowed_bn: ['ছোট ফুজি আপেল', 'পরিমিত পাকা পেঁপে', 'মিষ্টি নাশপাতি', 'স্ট্রবেরি'],
            allowed_en: ['Small Fuji Apple', 'Portioned Papaya', 'Sweet Pear', 'Strawberries'],
            restricted_bn: 'অতিরিক্ত পটাশিয়ামযুক্ত ফল যেমন বড় কলা বা শুকনো ডালিম সীমিত রাখা হয়।',
            restricted_en: 'Restricts high-potassium fruits like large bananas or dates.',
        },
        {
            key: 'heart',
            title_bn: 'হার্ট ও প্রেশার কন্ট্রোল (Cardio Boost)',
            title_en: 'Heart & Cholesterol Care',
            color: '#DC2626',
            lightColor: '#FEE2E2',
            icon: 'heart',
            desc_bn: 'উচ্চ পলিফেনল ও পেকটিন ফাইবার যা অফিসের স্ট্রেস কমায় এবং ধমনী সুস্থ রাখে।',
            desc_en: 'High polyphenols & soluble fiber to reduce work stress and support clear arteries.',
            allowed_bn: ['বেদানা / ডালিম', 'ভিটামিন C মাল্টা', 'ড্রাগন ফল', 'রেড আপেল'],
            allowed_en: ['Pomegranate seeds', 'Sweet Malta', 'Red Dragon Fruit', 'Red Apple'],
            restricted_bn: 'লবণাক্ত প্রক্রিয়াজাত বা প্রিজারভেটিভ যুক্ত ফ্রুট চাট সম্পূর্ণ নিষিদ্ধ।',
            restricted_en: 'Zero added table salt, zero preservatives or artificial colors.',
        },
    ];

    return (
        <ScrollView style={styles.container} contentContainerStyle={styles.content} showsVerticalScrollIndicator={false}>
            {/* Header intro */}
            <View style={styles.headerBox}>
                <Text style={styles.headerSubtitle}>
                    {lang === 'bn' ? 'বিশেষ শারীরিক চাহিদার যত্ন' : 'Specialized Clinical Nutrition'}
                </Text>
                <Text style={styles.headerTitle}>
                    {lang === 'bn' ? 'রোগভেদে নিরাপদ ও পুষ্টিকর ফলের বাউল' : 'Safe & Tailored Fruit Bowls for Health Conditions'}
                </Text>
                <Text style={styles.headerDesc}>
                    {lang === 'bn'
                        ? 'আপনার যদি ডায়াবেটিস, উচ্চ রক্তচাপ বা কিডনি সমস্যা থাকে, তবে ভয় নেই। আমাদের পুষ্টিবিদ আপনার শরীরের উপযোগী ফল নির্ধারণ করে প্রস্তুত করেন।'
                        : 'If you have diabetes, kidney sensitivity, or cardiovascular concerns, our dietitian curates fruits medically suited for you.'}
                </Text>
            </View>

            {/* Health Category Cards */}
            {healthCategories.map((cat) => (
                <View key={cat.key} style={styles.catCard}>
                    <View style={styles.catHeader}>
                        <View style={[styles.iconCircle, { backgroundColor: cat.lightColor }]}>
                            <Ionicons name={cat.icon} size={22} color={cat.color} />
                        </View>
                        <View style={{ flex: 1 }}>
                            <Text style={styles.catTitle}>{lang === 'bn' ? cat.title_bn : cat.title_en}</Text>
                            <Text style={styles.catDesc}>{lang === 'bn' ? cat.desc_bn : cat.desc_en}</Text>
                        </View>
                    </View>

                    {/* Allowed Fruits Tag List */}
                    <Text style={styles.subHeading}>{lang === 'bn' ? 'অনুমোদিত ও অন্তর্ভুক্ত ফলসমূহ:' : 'Included Safe Fruits:'}</Text>
                    <View style={styles.tagGrid}>
                        {(lang === 'bn' ? cat.allowed_bn : cat.allowed_en).map((fruit, idx) => (
                            <View key={idx} style={styles.tagPill}>
                                <Ionicons name="checkmark-done" size={14} color={Colors.primary} />
                                <Text style={styles.tagText}>{fruit}</Text>
                            </View>
                        ))}
                    </View>

                    {/* Restricted Notice */}
                    <View style={styles.restrictedBox}>
                        <Ionicons name="alert-circle" size={16} color="#DC2626" />
                        <Text style={styles.restrictedText}>
                            {lang === 'bn' ? cat.restricted_bn : cat.restricted_en}
                        </Text>
                    </View>

                    {/* Action Button */}
                    <TouchableOpacity
                        style={[styles.selectConditionBtn, { backgroundColor: cat.color }]}
                        onPress={() => onSelectCondition(cat.key)}
                    >
                        <Text style={styles.selectConditionBtnText}>
                            {lang === 'bn' ? `এই প্রোফাইলে প্যাকেজ নির্বাচন করুন` : `Select this profile for Desk`}
                        </Text>
                        <Ionicons name="arrow-forward" size={16} color="#FFFFFF" />
                    </TouchableOpacity>
                </View>
            ))}

            {/* 3 Pillars of NutriDesk Quality */}
            <View style={styles.qualityCard}>
                <Text style={styles.qualityTitle}>
                    {lang === 'bn' ? 'NutriDesk এর হাইজিন ও নিরাপত্তা প্রতিশ্রুতি' : 'NutriDesk Hygiene & Food Safety'}
                </Text>

                <View style={styles.qualityRow}>
                    <Ionicons name="water" size={20} color={Colors.primary} />
                    <View style={styles.qualityRowText}>
                        <Text style={styles.qualityItemTitle}>{lang === 'bn' ? 'ওজোন (Ozone) ডিসইনফেকশন' : 'Ozone Disinfection'}</Text>
                        <Text style={styles.qualityItemDesc}>
                            {lang === 'bn' ? 'ফরমালিন ও সকল কীটনাশক দূর করতে ওজোনাইজড পানি দিয়ে ডবল ওয়াশ।' : 'Ozone water double wash eliminates pesticide and surface microbes.'}
                        </Text>
                    </View>
                </View>

                <View style={styles.qualityRow}>
                    <Ionicons name="cube" size={20} color={Colors.secondary} />
                    <View style={styles.qualityRowText}>
                        <Text style={styles.qualityItemTitle}>{lang === 'bn' ? 'ফুড-গ্রেড সিল্ড প্যাকেজিং' : 'Food-Grade Sealed Containers'}</Text>
                        <Text style={styles.qualityItemDesc}>
                            {lang === 'bn' ? '১০০% রিসাইক্লেবল ওয়ান-টাইম এয়ারটাইট বাউল, যাতে ধুলোবালি স্পর্শ না করে।' : 'Airtight hygienic bowls sealed directly in clean preparation kitchen.'}
                        </Text>
                    </View>
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
    headerBox: {
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 18,
        marginBottom: 16,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    headerSubtitle: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.primaryDark,
        textTransform: 'uppercase',
    },
    headerTitle: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.text,
        marginTop: 4,
        marginBottom: 8,
        lineHeight: 24,
    },
    headerDesc: {
        fontSize: 12,
        color: Colors.textSecondary,
        lineHeight: 18,
    },
    catCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 18,
        marginBottom: 16,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    catHeader: {
        flexDirection: 'row',
        gap: 12,
        alignItems: 'flex-start',
        marginBottom: 14,
    },
    iconCircle: {
        width: 44,
        height: 44,
        borderRadius: 22,
        justifyContent: 'center',
        alignItems: 'center',
    },
    catTitle: {
        fontSize: 16,
        fontWeight: '800',
        color: Colors.text,
    },
    catDesc: {
        fontSize: 12,
        color: Colors.textSecondary,
        marginTop: 3,
        lineHeight: 16,
    },
    subHeading: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.textMuted,
        marginBottom: 8,
        textTransform: 'uppercase',
    },
    tagGrid: {
        flexDirection: 'row',
        flexWrap: 'wrap',
        gap: 8,
        marginBottom: 12,
    },
    tagPill: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.background,
        paddingHorizontal: 10,
        paddingVertical: 6,
        borderRadius: 10,
        gap: 6,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    tagText: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.text,
    },
    restrictedBox: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: '#FEF2F2',
        padding: 10,
        borderRadius: 10,
        gap: 8,
        marginBottom: 14,
    },
    restrictedText: {
        flex: 1,
        fontSize: 11,
        color: '#991B1B',
        fontWeight: '600',
    },
    selectConditionBtn: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        paddingVertical: 12,
        borderRadius: 14,
        gap: 8,
    },
    selectConditionBtnText: {
        color: '#FFFFFF',
        fontSize: 12,
        fontWeight: '800',
    },
    qualityCard: {
        backgroundColor: '#F0FDF4',
        borderRadius: 20,
        padding: 18,
        borderWidth: 1,
        borderColor: '#BBF7D0',
        gap: 14,
    },
    qualityTitle: {
        fontSize: 14,
        fontWeight: '800',
        color: '#166534',
        marginBottom: 2,
    },
    qualityRow: {
        flexDirection: 'row',
        gap: 12,
        alignItems: 'flex-start',
    },
    qualityRowText: {
        flex: 1,
    },
    qualityItemTitle: {
        fontSize: 12,
        fontWeight: '800',
        color: Colors.text,
    },
    qualityItemDesc: {
        fontSize: 11,
        color: Colors.textSecondary,
        marginTop: 2,
        lineHeight: 16,
    },
});
