import React from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, Alert } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '../constants/colors';

export default function ProfileOrdersScreen({ lang, t, onToggleLang }) {
    const orders = [
        {
            orderId: 'ND-2026-0891',
            package: 'শক্তি প্যাকেজ (Shakti Solo 30-Day)',
            date: 'Oct 01, 2026',
            amount: 1390,
            paymentMethod: 'bKash Tokenized',
            status: 'active',
            status_bn: 'সক্রিয় প্ল্যান',
            status_en: 'Active Subscription',
        },
        {
            orderId: 'ND-2026-0412',
            package: 'শক্তি প্যাকেজ (7-Day Trial)',
            date: 'Sep 15, 2026',
            amount: 450,
            paymentMethod: 'bKash Gateway',
            status: 'completed',
            status_bn: 'সম্পন্ন',
            status_en: 'Completed',
        },
    ];

    const showInvoiceAlert = (orderId) => {
        Alert.alert(
            lang === 'bn' ? 'ডিজিটাল ইনভয়েস' : 'Digital Invoice',
            lang === 'bn'
                ? `ইনভয়েস #${orderId} ভ্যাট ও ট্যাক্স চালানের কপি প্রস্তুত রয়েছে। আপনি কাস্টমার পোর্টাল বা অ্যাপ থেকে ডাউনলোড করতে পারেন।`
                : `Invoice #${orderId} with VAT breakdown is available for corporate expense claims.`
        );
    };

    return (
        <ScrollView style={styles.container} contentContainerStyle={styles.content} showsVerticalScrollIndicator={false}>
            {/* User Profile Card */}
            <View style={styles.profileCard}>
                <View style={styles.profileRow}>
                    <View style={styles.avatarCircle}>
                        <Ionicons name="person" size={28} color={Colors.primary} />
                    </View>
                    <View style={{ flex: 1 }}>
                        <Text style={styles.userName}>তানভীর আহমেদ (Tanvir)</Text>
                        <Text style={styles.userRole}>Senior Software Engineer</Text>
                        <Text style={styles.userCompany}>Tech Park BD • Gulshan-1, Dhaka</Text>
                    </View>
                </View>

                {/* Desk details grid */}
                <View style={styles.deskGrid}>
                    <View style={styles.deskItem}>
                        <Text style={styles.deskItemLabel}>{t.officeFloor}</Text>
                        <Text style={styles.deskItemVal}>4th Floor</Text>
                    </View>
                    <View style={styles.deskItemDivider} />
                    <View style={styles.deskItem}>
                        <Text style={styles.deskItemLabel}>{t.deskNumber}</Text>
                        <Text style={styles.deskItemVal}>Desk #24</Text>
                    </View>
                    <View style={styles.deskItemDivider} />
                    <View style={styles.deskItem}>
                        <Text style={styles.deskItemLabel}>{t.deliverySlot}</Text>
                        <Text style={styles.deskItemVal}>10:00 - 11:00 AM</Text>
                    </View>
                </View>
            </View>

            {/* Language Switcher Card */}
            <View style={styles.settingCard}>
                <View style={styles.settingLeft}>
                    <Ionicons name="language" size={20} color={Colors.primary} />
                    <View>
                        <Text style={styles.settingTitle}>
                            {lang === 'bn' ? 'ভাষা পরিবর্তন (Language)' : 'Switch Language (ভাষা)'}
                        </Text>
                        <Text style={styles.settingSub}>
                            {lang === 'bn' ? 'বর্তমান ভাষা: বাংলা' : 'Current: English'}
                        </Text>
                    </View>
                </View>

                <TouchableOpacity style={styles.langBtn} onPress={onToggleLang}>
                    <Text style={styles.langBtnText}>{lang === 'bn' ? 'Switch to English' : 'বাংলায় দেখুন'}</Text>
                </TouchableOpacity>
            </View>

            {/* Order History */}
            <Text style={styles.sectionTitle}>
                {lang === 'bn' ? 'অর্ডার ও ইনভয়েস ইতিহাস' : 'Subscription & Invoices'}
            </Text>

            {orders.map((ord) => (
                <View key={ord.orderId} style={styles.orderCard}>
                    <View style={styles.orderHeader}>
                        <View>
                            <Text style={styles.orderId}>#{ord.orderId}</Text>
                            <Text style={styles.orderDate}>{ord.date}</Text>
                        </View>
                        <View style={[styles.orderStatusBadge, ord.status === 'active' ? styles.statusActive : styles.statusCompleted]}>
                            <Text style={[styles.orderStatusText, ord.status === 'active' ? styles.statusActiveText : styles.statusCompletedText]}>
                                {lang === 'bn' ? ord.status_bn : ord.status_en}
                            </Text>
                        </View>
                    </View>

                    <Text style={styles.orderPkgName}>{ord.package}</Text>

                    <View style={styles.orderFooter}>
                        <Text style={styles.orderPrice}>৳{ord.amount.toLocaleString()}</Text>
                        <TouchableOpacity style={styles.invoiceBtn} onPress={() => showInvoiceAlert(ord.orderId)}>
                            <Ionicons name="document-text-outline" size={14} color={Colors.primary} />
                            <Text style={styles.invoiceBtnText}>{lang === 'bn' ? 'ইনভয়েস দেখুন' : 'View Invoice'}</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            ))}

            {/* Support Box */}
            <View style={styles.supportBox}>
                <Text style={styles.supportTitle}>
                    {lang === 'bn' ? 'ডেলিভারি হেল্প ও কাস্টমার সাপোর্ট' : 'Desk Delivery Support'}
                </Text>
                <Text style={styles.supportDesc}>
                    {lang === 'bn'
                        ? 'অফিস বা ডেস্ক পরিবর্তন অথবা বিশেষ ফ্রুট অ্যালার্জির জন্য হেল্পলাইনে যোগাযোগ করুন।'
                        : 'Contact us for desk location change, delivery time adjustment or fruit allergies.'}
                </Text>

                <View style={styles.supportActionRow}>
                    <View style={styles.supportPill}>
                        <Ionicons name="call" size={15} color={Colors.primary} />
                        <Text style={styles.supportPillText}>09612-NUTRIDESK</Text>
                    </View>
                    <View style={styles.supportPill}>
                        <Ionicons name="logo-whatsapp" size={15} color="#16A34A" />
                        <Text style={[styles.supportPillText, { color: '#16A34A' }]}>+880 1711-223344</Text>
                    </View>
                </View>
            </View>

            <Text style={styles.versionInfo}>NutriDesk Mobile v1.0.0 • Fresh Desk Portions</Text>
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
    profileCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 20,
        padding: 18,
        borderWidth: 1,
        borderColor: Colors.border,
        marginBottom: 16,
    },
    profileRow: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 14,
        marginBottom: 16,
    },
    avatarCircle: {
        width: 52,
        height: 52,
        borderRadius: 26,
        backgroundColor: Colors.primaryLight,
        justifyContent: 'center',
        alignItems: 'center',
    },
    userName: {
        fontSize: 16,
        fontWeight: '800',
        color: Colors.text,
    },
    userRole: {
        fontSize: 12,
        color: Colors.textSecondary,
        marginTop: 2,
    },
    userCompany: {
        fontSize: 11,
        color: Colors.textMuted,
        marginTop: 2,
    },
    deskGrid: {
        flexDirection: 'row',
        backgroundColor: Colors.background,
        borderRadius: 12,
        padding: 10,
        justifyContent: 'space-around',
        alignItems: 'center',
        borderWidth: 1,
        borderColor: Colors.border,
    },
    deskItem: {
        alignItems: 'center',
    },
    deskItemLabel: {
        fontSize: 9,
        fontWeight: '700',
        color: Colors.textMuted,
        textTransform: 'uppercase',
    },
    deskItemVal: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.text,
        marginTop: 2,
    },
    deskItemDivider: {
        width: 1,
        height: 20,
        backgroundColor: Colors.border,
    },
    settingCard: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: '#FFFFFF',
        borderRadius: 16,
        padding: 14,
        borderWidth: 1,
        borderColor: Colors.border,
        marginBottom: 18,
    },
    settingLeft: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 12,
    },
    settingTitle: {
        fontSize: 13,
        fontWeight: '700',
        color: Colors.text,
    },
    settingSub: {
        fontSize: 11,
        color: Colors.textSecondary,
        marginTop: 2,
    },
    langBtn: {
        backgroundColor: Colors.primaryLight,
        paddingHorizontal: 12,
        paddingVertical: 6,
        borderRadius: 10,
    },
    langBtnText: {
        fontSize: 11,
        fontWeight: '800',
        color: Colors.primaryDark,
    },
    sectionTitle: {
        fontSize: 13,
        fontWeight: '800',
        color: Colors.text,
        marginBottom: 10,
    },
    orderCard: {
        backgroundColor: '#FFFFFF',
        borderRadius: 16,
        padding: 14,
        marginBottom: 10,
        borderWidth: 1,
        borderColor: Colors.border,
    },
    orderHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'flex-start',
        marginBottom: 6,
    },
    orderId: {
        fontSize: 13,
        fontWeight: '800',
        color: Colors.text,
    },
    orderDate: {
        fontSize: 11,
        color: Colors.textMuted,
        marginTop: 2,
    },
    orderStatusBadge: {
        paddingHorizontal: 8,
        paddingVertical: 3,
        borderRadius: 8,
    },
    statusActive: {
        backgroundColor: '#D1FAE5',
    },
    statusActiveText: {
        color: '#065F46',
        fontSize: 10,
        fontWeight: '800',
    },
    statusCompleted: {
        backgroundColor: '#F1F5F9',
    },
    statusCompletedText: {
        color: Colors.textSecondary,
        fontSize: 10,
        fontWeight: '700',
    },
    orderPkgName: {
        fontSize: 13,
        fontWeight: '700',
        color: Colors.text,
        marginBottom: 10,
    },
    orderFooter: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        borderTopWidth: 1,
        borderTopColor: Colors.border,
        paddingTop: 10,
    },
    orderPrice: {
        fontSize: 15,
        fontWeight: '900',
        color: Colors.text,
    },
    invoiceBtn: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 4,
        paddingHorizontal: 8,
        paddingVertical: 4,
    },
    invoiceBtnText: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.primary,
    },
    supportBox: {
        backgroundColor: '#ECFDF5',
        borderRadius: 16,
        padding: 16,
        marginTop: 8,
        borderWidth: 1,
        borderColor: '#A7F3D0',
    },
    supportTitle: {
        fontSize: 13,
        fontWeight: '800',
        color: '#065F46',
        marginBottom: 4,
    },
    supportDesc: {
        fontSize: 11,
        color: '#047857',
        lineHeight: 16,
        marginBottom: 12,
    },
    supportActionRow: {
        flexDirection: 'row',
        gap: 8,
    },
    supportPill: {
        flexDirection: 'row',
        alignItems: 'center',
        gap: 6,
        backgroundColor: '#FFFFFF',
        paddingHorizontal: 12,
        paddingVertical: 8,
        borderRadius: 10,
        borderWidth: 1,
        borderColor: '#A7F3D0',
    },
    supportPillText: {
        fontSize: 11,
        fontWeight: '700',
        color: Colors.text,
    },
    versionInfo: {
        textAlign: 'center',
        fontSize: 10,
        color: Colors.textMuted,
        marginTop: 20,
    },
});
