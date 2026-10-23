import React, { useState } from 'react';
import { View, Text, StyleSheet, Modal, TouchableOpacity, TextInput, ActivityIndicator } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';

export default function BkashModal({ visible, orderData, onClose, onSuccess }) {
    if (!orderData) return null;

    const [accountNumber, setAccountNumber] = useState(orderData.phone || '01711223344');
    const [otp, setOtp] = useState('123456');
    const [pin, setPin] = useState('12345');
    const [loading, setLoading] = useState(false);

    const handlePay = () => {
        setLoading(true);
        setTimeout(() => {
            setLoading(false);
            onSuccess();
        }, 1200);
    };

    return (
        <Modal visible={visible} animationType="slide" transparent>
            <View style={styles.overlay}>
                <View style={styles.card}>
                    {/* Pink Header */}
                    <View style={styles.header}>
                        <View style={styles.bKashIconBox}>
                            <Text style={styles.bKashLogo}>bKash</Text>
                        </View>
                        <Text style={styles.merchantTitle}>NutriDesk Fresh Fruit Ltd</Text>
                        <Text style={styles.invoiceText}>Package: {orderData.packageData.name_bn}</Text>

                        <View style={styles.amountBadge}>
                            <Text style={styles.amountLabel}>AMOUNT TO PAY</Text>
                            <Text style={styles.amountValue}>৳ {orderData.totalAmount.toLocaleString()}</Text>
                        </View>
                    </View>

                    {/* Input Form */}
                    <View style={styles.body}>
                        <View style={styles.field}>
                            <Text style={styles.label}>Your bKash Account Number</Text>
                            <TextInput
                                style={styles.input}
                                value={accountNumber}
                                onChangeText={setAccountNumber}
                                keyboardType="phone-pad"
                            />
                        </View>

                        <View style={styles.field}>
                            <Text style={styles.label}>Verification OTP (Demo: 123456)</Text>
                            <TextInput
                                style={[styles.input, styles.codeText]}
                                value={otp}
                                onChangeText={setOtp}
                                keyboardType="number-pad"
                            />
                        </View>

                        <View style={styles.field}>
                            <Text style={styles.label}>bKash PIN (Demo: 12345)</Text>
                            <TextInput
                                style={[styles.input, styles.codeText]}
                                value={pin}
                                onChangeText={setPin}
                                secureTextEntry
                                keyboardType="number-pad"
                            />
                        </View>

                        <View style={styles.securityNotice}>
                            <Ionicons name="shield-checkmark" size={16} color={Colors.bkash} />
                            <Text style={styles.securityText}>256-Bit Encrypted Secure Payment Gateway</Text>
                        </View>

                        {/* Pay Button */}
                        <TouchableOpacity style={styles.payBtn} onPress={handlePay} disabled={loading}>
                            {loading ? (
                                <ActivityIndicator color="#FFFFFF" />
                            ) : (
                                <Text style={styles.payBtnText}>
                                    Confirm Payment ৳ {orderData.totalAmount.toLocaleString()}
                                </Text>
                            )}
                        </TouchableOpacity>

                        <TouchableOpacity style={styles.cancelBtn} onPress={onClose} disabled={loading}>
                            <Text style={styles.cancelBtnText}>Cancel</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </View>
        </Modal>
    );
}

const styles = StyleSheet.create({
    overlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.7)',
        justifyContent: 'center',
        padding: 20,
    },
    card: {
        backgroundColor: '#FFFFFF',
        borderRadius: 24,
        overflow: 'hidden',
    },
    header: {
        backgroundColor: Colors.bkash,
        padding: 24,
        alignItems: 'center',
    },
    bKashIconBox: {
        backgroundColor: '#FFFFFF',
        paddingHorizontal: 16,
        paddingVertical: 6,
        borderRadius: 12,
        marginBottom: 10,
    },
    bKashLogo: {
        color: Colors.bkash,
        fontSize: 18,
        fontWeight: '900',
    },
    merchantTitle: {
        color: '#FFFFFF',
        fontSize: 14,
        fontWeight: '800',
    },
    invoiceText: {
        color: '#FCE7F3',
        fontSize: 11,
        marginTop: 2,
    },
    amountBadge: {
        backgroundColor: 'rgba(0,0,0,0.15)',
        paddingVertical: 8,
        paddingHorizontal: 20,
        borderRadius: 14,
        marginTop: 12,
        alignItems: 'center',
    },
    amountLabel: {
        color: '#FBCFE8',
        fontSize: 9,
        fontWeight: '700',
        letterSpacing: 1,
    },
    amountValue: {
        color: '#FFFFFF',
        fontSize: 22,
        fontWeight: '900',
    },
    body: {
        padding: 20,
    },
    field: {
        marginBottom: 12,
    },
    label: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.textSecondary,
        marginBottom: 4,
    },
    input: {
        borderWidth: 1.5,
        borderColor: Colors.border,
        borderRadius: 12,
        paddingHorizontal: 12,
        paddingVertical: 10,
        fontSize: 14,
        color: Colors.text,
        backgroundColor: Colors.background,
    },
    codeText: {
        textAlign: 'center',
        letterSpacing: 4,
        fontWeight: '800',
    },
    securityNotice: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
        backgroundColor: '#FDF2F8',
        padding: 8,
        borderRadius: 10,
        marginBottom: 16,
    },
    securityText: {
        fontSize: 10,
        color: '#9D174D',
        fontWeight: '600',
    },
    payBtn: {
        backgroundColor: Colors.bkash,
        paddingVertical: 14,
        borderRadius: 14,
        alignItems: 'center',
        shadowColor: Colors.bkash,
        shadowOpacity: 0.3,
        shadowRadius: 8,
        elevation: 4,
    },
    payBtnText: {
        color: '#FFFFFF',
        fontSize: 14,
        fontWeight: '800',
    },
    cancelBtn: {
        paddingVertical: 10,
        alignItems: 'center',
        marginTop: 4,
    },
    cancelBtnText: {
        color: Colors.textMuted,
        fontSize: 12,
        fontWeight: '600',
    },
});
