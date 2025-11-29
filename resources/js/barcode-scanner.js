// Global barcode scanner module
if (typeof window.BarcodeScanner === 'undefined') {
    window.BarcodeScanner = {
        zxingReader: null,
        activeCameraId: null,
        isScanning: false,
        scanTimeout: null,
        timeoutDuration: 60000, // 60 seconds

        clearTimeout() {
            if (this.scanTimeout) {
                clearTimeout(this.scanTimeout);
                this.scanTimeout = null;
            }
        },

        startTimeout() {
            this.clearTimeout();
            this.scanTimeout = setTimeout(() => {
                console.log("Scanner timeout: No barcode detected within 60 seconds");
                const status = document.getElementById('scanner-status');
                if (status && this.isScanning) {
                    status.innerText = "⏱️ Timeout: No barcode detected. Stopping scanner...";
                }
                this.stop();
            }, this.timeoutDuration);
        },

        async start() {
            if (this.isScanning) return;

            this.isScanning = true;
            const status = document.getElementById('scanner-status');
            if (status) status.innerText = "Initializing camera…";

            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
                    if (status) status.innerText = "❌ Camera access not available on this device/connection.";
                    console.error("mediaDevices not supported");
                    this.isScanning = false;
                    return;
                }

                if (!this.zxingReader) {
                    const ZXing = window.ZXing;
                    if (!ZXing) {
                        console.error("ZXing library not loaded");
                        if (status) status.innerText = "❌ Scanner library not available.";
                        this.isScanning = false;
                        return;
                    }
                    this.zxingReader = new ZXing.BrowserMultiFormatReader();
                    console.log("ZXing reader initialized");
                }

                const devices = await navigator.mediaDevices.enumerateDevices();
                const cameras = devices.filter(d => d.kind === "videoinput");

                if (!cameras.length) {
                    if (status) status.innerText = "❌ No camera detected.";
                    this.isScanning = false;
                    return;
                }

                this.activeCameraId = cameras.find(c => c.label.toLowerCase().includes("back"))?.deviceId || cameras[0].deviceId;
                if (status) status.innerText = "📷 Camera active. Point at barcode...";

                // Start the timeout timer
                this.startTimeout();

                this.zxingReader.decodeFromVideoDevice(
                    this.activeCameraId,
                    'qr-video',
                    async (result, error) => {
                        if (result) {
                            console.log("✓ Barcode detected:", result.text);
                            const statusEl = document.getElementById('scanner-status');
                            if (statusEl) statusEl.innerText = "✓ Barcode: " + result.text;

                            // Clear timeout on successful scan
                            this.clearTimeout();

                            if (window.Livewire) {
                                Livewire.dispatch('barcodeDetected', { barcode: result.text });
                            }

                            this.stop();
                        }

                        if (error && error.name !== 'NotFoundException') {
                            console.warn("Decode error:", error.name, error.message);
                        }
                    }
                );

            } catch (error) {
                console.error("Scanner error:", error);
                const statusEl = document.getElementById('scanner-status');
                if (statusEl) {
                    if (error.message.includes('Permission denied')) {
                        statusEl.innerText = "❌ Camera permission denied.";
                    } else if (error.message.includes('enumerateDevices')) {
                        statusEl.innerText = "❌ Camera access not available. Use HTTPS.";
                    } else {
                        statusEl.innerText = "❌ Error: " + error.message;
                    }
                }
                this.isScanning = false;
                this.clearTimeout();
            }
        },

        async stop() {
            if (!this.isScanning) return;

            this.isScanning = false;
            this.clearTimeout();
            const status = document.getElementById('scanner-status');

            try {
                if (this.zxingReader) {
                    await this.zxingReader.reset();
                    console.log("Scanner stopped");
                }
            } catch (error) {
                console.error("Error stopping scanner:", error);
            }

            if (status) {
                status.innerText = "Scanner stopped.";
            }
        }
    };

    // Expose functions for backward compatibility
    window.startZXingScanner = () => window.BarcodeScanner.start();
    window.stopZXingScanner = () => window.BarcodeScanner.stop();

    // Auto-cleanup on page navigation
    const originalStop = window.BarcodeScanner.stop.bind(window.BarcodeScanner);
    const cleanupScanner = () => {
        if (window.BarcodeScanner.isScanning) {
            originalStop();
        }
    };

    document.addEventListener('livewire:navigating', cleanupScanner);
    document.addEventListener('livewire:navigated', cleanupScanner);
    window.addEventListener('beforeunload', cleanupScanner);
    window.addEventListener('pagehide', cleanupScanner);
}
