# 🌐 Understanding Subnet Calculations: 192.168.1.0/24 to /26

## 1. Understanding the Original Network
```
Original Network: 192.168.1.0/24
Binary representation of last octet:
00000000 - 11111111 (0-255)
```

## 2. Understanding /24 vs /26
```
/24 = 11111111.11111111.11111111.00000000
/26 = 11111111.11111111.11111111.11000000
                                  ^^
                              These two bits
                              create 4 subnets
```

## 3. Mathematical Breakdown

### Step 1: Calculate Number of Subnets
```
Difference in subnet bits = 26 - 24 = 2 bits
Number of subnets = 2² = 4 subnets
```

### Step 2: Calculate Hosts per Subnet
```
Host bits in /26 = 32 - 26 = 6 bits
Hosts per subnet = 2⁶ - 2 = 64 - 2 = 62 usable hosts
(-2 for network and broadcast addresses)
```

### Step 3: Calculate Subnet Ranges
```
Subnet size = 256 ÷ 2² = 256 ÷ 4 = 64 addresses per subnet
```

## 4. Detailed Subnet Breakdown

### Subnet 1 (192.168.1.0/26)
```
Network:   192.168.1.0   (00000000)
First IP:  192.168.1.1   (00000001)
Last IP:   192.168.1.62  (00111110)
Broadcast: 192.168.1.63  (00111111)
```

### Subnet 2 (192.168.1.64/26)
```
Network:   192.168.1.64  (01000000)
First IP:  192.168.1.65  (01000001)
Last IP:   192.168.1.126 (01111110)
Broadcast: 192.168.1.127 (01111111)
```

### Subnet 3 (192.168.1.128/26)
```
Network:   192.168.1.128 (10000000)
First IP:  192.168.1.129 (10000001)
Last IP:   192.168.1.190 (10111110)
Broadcast: 192.168.1.191 (10111111)
```

### Subnet 4 (192.168.1.192/26)
```
Network:   192.168.1.192 (11000000)
First IP:  192.168.1.193 (11000001)
Last IP:   192.168.1.254 (11111110)
Broadcast: 192.168.1.255 (11111111)
```

## 5. Quick Reference Table

| Subnet | Network Address | First Usable | Last Usable | Broadcast |
|--------|----------------|--------------|-------------|-----------|
| 1 | 192.168.1.0   | 192.168.1.1   | 192.168.1.62  | 192.168.1.63  |
| 2 | 192.168.1.64  | 192.168.1.65  | 192.168.1.126 | 192.168.1.127 |
| 3 | 192.168.1.128 | 192.168.1.129 | 192.168.1.190 | 192.168.1.191 |
| 4 | 192.168.1.192 | 192.168.1.193 | 192.168.1.254 | 192.168.1.255 |

## 6. Key Formulas
```
Number of subnets = 2^(new mask - old mask)
Hosts per subnet = 2^(32 - new mask) - 2
Subnet size = 256 ÷ (number of subnets)
```
