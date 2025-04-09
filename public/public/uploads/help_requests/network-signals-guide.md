# 📡 Computer Networks: Signals, Transmission & Topology
## 1. Signal Fundamentals

### 1.1 Sine Waves & Basic Concepts
- **Sine Wave Components:**
  ```
  y = A sin(ωt)
  where:
  A = Amplitude
  ω = Angular frequency (2πf)
  t = Time
  ```

- **Key Terms:**
  - **Period (T)**: Time for one complete cycle
  - **Frequency (f)**: Number of cycles per second (Hz)
  - **Relationship**: f = 1/T
  - **Angular Speed (ω)**: ω = 2πf = 360°/T

### 1.2 Wave Properties
- **Speed of Light**: c = 300,000 km/s
- **Wavelength (λ)**: 
  ```
  λ = c/f
  Examples:
  - 1 Hz → 300,000 km
  - 1 KHz → 300 km
  - 1 MHz → 300 m
  ```

### 1.3 Signal Characteristics
1. **Amplitude**: Signal strength/magnitude
2. **Phase**: Timing of wave relative to reference
3. **Frequency**: Rate of oscillation

### 1.4 Signal Modifications
- **Attenuation**: Signal weakening
- **Amplification**: Signal strengthening
- **Delay**: Time shift
- **Noise**: Unwanted signal interference

## 2. Digital Communication

### 2.1 Bandwidth and Bitrate
#### Nyquist's Theorem
```
R = 2H log₂L
where:
R = Data rate (bits/sec)
H = Channel bandwidth (Hz)
L = Number of signal levels
```

#### Shannon's Law
```
R = H log₂(1 + S/N)
where:
S = Signal level
N = Noise level
```

### 2.2 Transmission Methods

#### Asynchronous Transmission
- Sends one character at a time
- Uses start/stop bits
- Clock synchronization per character
- **Challenge**: Clock drift between sender/receiver

#### Synchronous Transmission
1. **Separate Clock Line**
   - Works for short distances
   - Additional synchronization needed
   
2. **Manchester Encoding**
   - Clock embedded in data signal
   - Transition at middle of each bit period
   - Baud rate = 2× bit rate

## 3. Error Detection & Control

### 3.1 Basic Error Detection
```
Probability Example:
Correct bit transmission: 0.8
Error probability: 0.2
```

### 3.2 Error Detection Methods

#### Simple Redundancy
```
0 → 00
1 → 11
Probability of wrong decoding = 0.04
```

#### Parity Checking
1. **Even Parity**
   ```
   Data: 1 0 1 0 0 1 0 1
   Parity: 0
   Transmitted: 1 0 1 0 0 1 0 1 0
   ```

2. **Odd Parity**
   ```
   Data: 1 0 1 0 0 1 0 1
   Parity: 1
   Transmitted: 1 0 1 0 0 1 0 1 1
   ```

- Can detect single errors
- Cannot detect double errors

## 4. Network Topologies

### 4.1 Basic Topologies

#### Point-to-Point
```
[A] ←→ [B]
```
- Direct connection between two nodes
- Simplest form of connection

#### Mesh
```
    [A]──[B]
     │ \/ │
     │ /\ │
    [C]──[D]
```
- Each node connects to every other node
- Highly reliable but complex

#### Star
```
     [A]
      │
[B]──[Hub]──[C]
      │
     [D]
```
- Central hub connects all nodes
- Easy management but single point of failure

#### Bus
```
──[A]──[B]──[C]──[D]──[E]──
```
- Single shared communication line
- Simple but vulnerable to breaks

### 4.2 Access Methods

#### TDMA (Time Division Multiple Access)
- Each node gets specific time slot
- Example: Node A: 1:00-2:00, Node B: 2:00-3:00

#### FDMA (Frequency Division Multiple Access)
- Each node gets specific frequency range
- Example: Node A: 1-2KHz, Node B: 2-3KHz

#### CDMA (Code Division Multiple Access)
- Each node uses unique code
- Allows simultaneous transmission

## 5. Communication Challenges

### 5.1 The Two Army Problem
- Illustrates impossibility of perfect coordination
- No guaranteed synchronization possible
- Example of fundamental communication limitations

### 5.2 Practical Considerations
1. **Clock Synchronization**
   - 1% clock difference → 0.01μs drift per bit
   - 50 samples → 0.5μs drift

2. **Error Types**
   - Bit errors
   - Framing errors
   - Synchronization errors

## 📝 Key Formulas Summary
```
f = 1/T (Frequency)
λ = c/f (Wavelength)
ω = 2πf (Angular frequency)
R = 2H log₂L (Nyquist)
R = H log₂(1 + S/N) (Shannon)
```
