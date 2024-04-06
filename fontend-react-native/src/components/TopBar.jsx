import React from 'react';
import { View, Text, Image, StyleSheet, StatusBar, SafeAreaView } from 'react-native';

const Header = () => {
    return (
        <SafeAreaView style={styles.safeArea}>
            <View style={styles.container}>
                <Text style={styles.textLogo}>Recepetarium</Text>
                <Image
                    source={require('../../assets/logo.png')}
                    style={styles.icon}
                />
            </View>
        </SafeAreaView>
    );
};

export default Header;

const styles = StyleSheet.create({
    safeArea: {
        backgroundColor: '#F582AE',
    },
    container: {
        flexDirection: "row",
        height: 85,
        justifyContent: 'center',
        alignItems: 'center'
    },
    textLogo: {
        fontSize: 30,
        marginTop: 10,
        marginLeft: 10,
        color: '#f7d3e1'
    },
    icon: {
        width: 35,
        height: 35,
        marginLeft: 5,
        marginTop: 12,
        borderRadius: 20,
    },
});
