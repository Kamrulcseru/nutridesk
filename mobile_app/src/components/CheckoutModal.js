import React, { useState } from 'react';
import { View, Text, StyleSheet, Modal, TouchableOpacity, TextInput, ScrollView } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';

export default function CheckoutModal({ visible, packageData, onClose, onProceedToPayment, lang, t }) {
    if (!packageData) return null;

    const [duration, setDuration] = useState('30_days');
    const [persons, setPersons] = useState(packageData.min_persons.toString());
    const [condition, setCondition] = useState('general');
    const [officeName, setOfficeName] = useState('Tech Park BD');
    const [officeFloor, setOfficeFloor] = useState('4th Floor');
    const [deskNumber, setDeskNumber] = useState('Desk #24');
    const [phone, setPhone] = useState('01711223344');
    const [paymentMethod, setPaymentMethod] = useState('bkash');

    const numPersons = parseInt(persons) || 1;
    const basePrice = duration === '7_days' ? packageData.price_7_days : packageData.price_30_days;
    const multiplier = numPersons > packageData.max_persons ? (numPersons / Math.max(packageData.max_persons, 1)) : 1;
    const totalAmount = Math.round(basePrice * multiplier);

    const handleConfirm = () => {
        onProceedToPayment({
            packageData,
            duration,
            persons: numPersons,
            condition,
            officeName,
            officeFloor,
            deskNumber,
            phone,
            paymentMethod,
            totalAmount,
        });
    };

    return (
        <Modal visible={visible} animationType="slide" transparent>
            <View style={styles.modalOverlay}>
                <View style={styles.modalContent}>
                    {/* Header */}
                    <View style={styles.header}>
                        <View>
                            <Text style={styles.headerSubtitle}>{t.checkoutTitle}</Text>
                            <Text style={styles.headerTitle}>
                                {lang === 'bn' ? packageData.name_bn : packageData.name_en}
                            </Text>
                        </View>
                        <TouchableOpacity onPress={onClose} style={styles.closeBtn}>
                            <Ionicons name="close" size={24} color={Colors.textSecondary} />
                        </TouchableOpacity>
                    </View>

                    <ScrollView showsVerticalScrollIndicator={false} contentContainerStyle={styles.scrollBody}>
                        {/* Duration Selector */}
                        <Text style={styles.sectionTitle}>১. মেয়াদের ধরণ (Duration)</Text>
                        <View style={styles.durationRow}>
                            <TouchableOpacity
                                style={[styles.durationCard, duration === '7_days' && styles.durationCardActive]}
                                onPress={() => setDuration('7_days')}
                            >
                                <Text style={[styles.durationTitle, duration === '7_days' && styles.durationTitleActive]}>
                                    ৭ দিনের ট্রায়াল
                                </Text>
                                <Text style={styles.durationPrice}>৳{packageData.price_7_days}</Text>
                                <Text style={styles.durationDays}>৫ কর্মদিবস</Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.durationCard, duration === '30_days' && styles.durationCardActive]}
                                onPress={() => setDuration('30_days')}
                            >
                                <Text style={[styles.durationTitle, duration === '30_days' && styles.durationTitleActive]}>
                                    ১ মাসের নিয়মিত
                                </Text>
                                <Text style={styles.durationPrice}>৳{packageData.price_30_days}</Text>
                                <Text style={styles.durationDays}>২২ কর্মদিবস</Text>
                            </TouchableOpacity>
                        </View>

                        {/* Persons */}
                        <View style={styles.inputGroup}>
                            <Text style={styles.inputLabel}>লোকসংখ্যা (Total Persons)</Text>
                            <TextInput
                                style={styles.input}
                                value={persons}
                                onChangeText={setPersons}
                                keyboardType="number-pad"
                            />
                        </View>

                        {/* Health Profile Selection */}
                        <Text style={styles.sectionTitle}>২. স্বাস্থ্য ও ডায়েট প্রোফাইল</Text>
                        <View style={styles.conditionGrid}>
                            <TouchableOpacity
                                style={[styles.conditionBtn, condition === 'general' && styles.conditionBtnActive]}
                                onPress={() => setCondition('general')}
                            >
                                <Ionicons name="nutrition" size={18} color={condition === 'general' ? Colors.primary : Colors.textMuted} />
                                <Text style={[styles.conditionText, condition === 'general' && styles.conditionTextActive]}>সাধারণ</Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.conditionBtn, condition === 'diabetes' && styles.conditionBtnActive]}
                                onPress={() => setCondition('diabetes')}
                            >
                                <Ionicons name="water" size={18} color={condition === 'diabetes' ? Colors.secondary : Colors.textMuted} />
                                <Text style={[styles.conditionText, condition === 'diabetes' && styles.conditionTextActive]}>ডায়াবেটিস (Low-GI)</Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.conditionBtn, condition === 'kidney' && styles.conditionBtnActive]}
                                onPress={() => setCondition('kidney')}
                            >
                                <Ionicons name="pulse" size={18} color={condition === 'kidney' ? Colors.info : Colors.textMuted} />
                                <Text style={[styles.conditionText, condition === 'kidney' && styles.conditionTextActive]}>কিডনি কেয়ার</Text>
                            </TouchableOpacity>
                        </View>

                        {/* Office Desk Information */}
                        <Text style={styles.sectionTitle}>৩. অফিস ডেলিভারি লোকেশন</Text>
                        <View style={styles.inputGroup}>
                            <Text style={styles.inputLabel}>কোম্পানি / অফিসের নাম</Text>
                            <TextInput style={styles.input} value={officeName} onChangeText={setOfficeName} />
                        </View>

                        <View style={styles.rowInputs}>
                            <View style={[styles.inputGroup, { flex: 1, marginRight: 8 }]}>
                                <Text style={styles.inputLabel}>ফ্লোর</Text>
                                <TextInput style={styles.input} value={officeFloor} onChangeText={setOfficeFloor} />
                            </View>
                            <View style={[styles.inputGroup, { flex: 1, marginLeft: 8 }]}>
                                <Text style={styles.inputLabel}>ডেস্ক নম্বর</Text>
                                <TextInput style={styles.input} value={deskNumber} onChangeText={setDeskNumber} />
                            </View>
                        </View>

                        <View style={styles.inputGroup}>
                            <Text style={styles.inputLabel}>মোবাইল নম্বর</Text>
                            <TextInput style={styles.input} value={phone} onChangeText={setPhone} keyboardType="phone-pad" />
                        </View>

                        {/* Payment Method */}
                        <Text style={styles.sectionTitle}>৪. পেমেন্ট পদ্ধতি</Text>
                        <View style={styles.paymentRow}>
                            <TouchableOpacity
                                style={[styles.paymentBtn, paymentMethod === 'bkash' && styles.paymentBtnActiveBkash]}
                                onPress={() => setPaymentMethod('bkash')}
                            >
                                <Text style={[styles.paymentBtnText, paymentMethod === 'bkash' && { color: Colors.bkash }]}>
                                    bKash (বিকাশ)
                                </Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.paymentBtn, paymentMethod === 'card' && styles.paymentBtnActive]}
                                onPress={() => setPaymentMethod('card')}
                            >
                                <Text style={[styles.paymentBtnText, paymentMethod === 'card' && { color: Colors.primary }]}>
                                    Card (কার্ড)
                                </Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.paymentBtn, paymentMethod === 'invoice' && styles.paymentBtnActive]}
                                onPress={() => setPaymentMethod('invoice')}
                            >
                                <Text style={[styles.paymentBtnText, paymentMethod === 'invoice' && { color: Colors.text }]}>
                                    মান্থলি বিল
                                </Text>
                            </TouchableOpacity>
                        </View>

                        {/* Total Summary */}
                        <View style={styles.summaryBox}>
                            <View style={styles.summaryRow}>
                                <Text style={styles.summaryLabel}>{t.totalPayable}:</Text>
                                <Text style={styles.summaryValue}>৳{totalAmount.toLocaleString()}</Text>
                            </View>
                            <Text style={styles.summarySub}>অফিস ডেস্কে ডেলিভারি সম্পূর্ণ ফ্রি ও ফুড-গ্রেড প্যাকেজসহ</Text>
                        </View>

                        {/* Submit Button */}
                        <TouchableOpacity style={styles.submitBtn} onPress={handleConfirm}>
                            <Text style={styles.submitBtnText}>
                                {paymentMethod === 'bkash' ? 'bKash দিয়ে পেমেন্ট করুন' : t.confirmAndPay} (৳{totalAmount})
                            </Text>
                        </TouchableOpacity>
                    </ScrollView>
                </View>
            </View>
        </Modal>
    );
}

const styles = StyleSheet.create({
    modalOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.6)',
        justifyContent: 'flex-end',
    },
    modalContent: {
        backgroundColor: Colors.card,
        borderTopLeftRadius: 28,
        borderTopRightRadius: 28,
        maxHeight: '90%',
        paddingTop: 20,
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        paddingHorizontal: 20,
        paddingBottom: 16,
        borderBottomWidth: 1,
        borderBottomColor: Colors.border,
    },
    headerSubtitle: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.primaryDark,
        textTransform: 'uppercase',
    },
    headerTitle: {
        fontSize: 18,
        fontWeight: '800',
        color: Colors.text,
        marginTop: 2,
    },
    closeBtn: {
        padding: 6,
        borderRadius: 20,
        backgroundColor: Colors.background,
    },
    scrollBody: {
        padding: 20,
        paddingBottom: 40,
    },
    sectionTitle: {
        fontSize: 13,
        fontWeight: '700',
        color: Colors.text,
        marginTop: 14,
        marginBottom: 10,
    },
    durationRow: {
        flexDirection: 'row',
        gap: 12,
    },
    durationCard: {
        flex: 1,
        borderWidth: 1.5,
        borderColor: Colors.border,
        borderRadius: 16,
        padding: 12,
        backgroundColor: Colors.card,
    },
    durationCardActive: {
        borderColor: Colors.primary,
        backgroundColor: Colors.primaryLight + '30',
    },
    durationTitle: {
        fontSize: 12,
        fontWeight: '700',
        color: Colors.textSecondary,
    },
    durationTitleActive: {
        color: Colors.primaryDark,
    },
    durationPrice: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.text,
        marginTop: 4,
    },
    durationDays: {
        fontSize: 10,
        color: Colors.textMuted,
        marginTop: 2,
    },
    inputGroup: {
        marginTop: 12,
    },
    inputLabel: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.textSecondary,
        marginBottom: 4,
    },
    input: {
        borderWidth: 1,
        borderColor: Colors.border,
        borderRadius: 12,
        paddingHorizontal: 12,
        paddingVertical: 10,
        fontSize: 13,
        color: Colors.text,
        backgroundColor: Colors.background,
    },
    rowInputs: {
        flexDirection: 'row',
    },
    conditionGrid: {
        flexDirection: 'row',
        gap: 8,
    },
    conditionBtn: {
        flex: 1,
        alignItems: 'center',
        paddingVertical: 10,
        borderWidth: 1,
        borderColor: Colors.border,
        borderRadius: 12,
        backgroundColor: Colors.background,
    },
    conditionBtnActive: {
        borderColor: Colors.primary,
        backgroundColor: Colors.primaryLight + '40',
    },
    conditionText: {
        fontSize: 10,
        fontWeight: '700',
        color: Colors.textSecondary,
        marginTop: 4,
        textAlign: 'center',
    },
    conditionTextActive: {
        color: Colors.primaryDark,
    },
    paymentRow: {
        flexDirection: 'row',
        gap: 8,
    },
    paymentBtn: {
        flex: 1,
        paddingVertical: 10,
        borderWidth: 1.5,
        borderColor: Colors.border,
        borderRadius: 12,
        alignItems: 'center',
        backgroundColor: Colors.card,
    },
    paymentBtnActive: {
        borderColor: Colors.primary,
        backgroundColor: Colors.primaryLight + '30',
    },
    paymentBtnActiveBkash: {
        borderColor: Colors.bkash,
        backgroundColor: '#FCE7F3',
    },
    paymentBtnText: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.textSecondary,
    },
    summaryBox: {
        backgroundColor: Colors.background,
        padding: 16,
        borderRadius: 16,
        marginTop: 18,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    summaryRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'baseline',
    },
    summaryLabel: {
        fontSize: 14,
        fontWeight: '800',
        color: Colors.text,
    },
    summaryValue: {
        fontSize: 22,
        fontWeight: '900',
        color: Colors.primaryDark,
    },
    summarySub: {
        fontSize: 10,
        color: Colors.textMuted,
        marginTop: 4,
    },
    submitBtn: {
        backgroundColor: Colors.primary,
        paddingVertical: 15,
        borderRadius: 16,
        alignItems: 'center',
        marginTop: 18,
        shadowColor: Colors.primary,
        shadowOpacity: 0.3,
        shadowRadius: 8,
        elevation: 4,
    },
    submitBtnText: {
        color: '#FFFFFF',
        fontSize: 14,
        fontWeight: '800',
    },
});
