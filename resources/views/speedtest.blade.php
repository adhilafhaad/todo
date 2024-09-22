<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Speed Test</title>
    <script>
        function startDownloadTest() {
            const downloadUrl = 'https://speed.hetzner.de/100MB.bin';  // Use an external URL for testing
            const startTime = new Date().getTime();
            const dataSizeMB = 100; // 100 MB file (you can adjust this)

            fetch(downloadUrl)
                .then(response => response.blob())  // Download the data
                .then(() => {
                    const endTime = new Date().getTime();
                    const timeTakenInSeconds = (endTime - startTime) / 1000;  // Convert ms to seconds
                    const downloadSpeedMbps = (dataSizeMB * 8) / timeTakenInSeconds;  // Calculate speed in Mbps
                    document.getElementById('downloadSpeed').innerText = `Download Speed: ${downloadSpeedMbps.toFixed(2)} Mbps`;
                })
                .catch(err => {
                    console.error('Download error:', err);
                    document.getElementById('downloadSpeed').innerText = 'Error testing download speed.';
                });
        }

        function startUploadTest() {
            const startTime = new Date().getTime();
            const dataSizeMB = 5; // 5 MB of random data for upload

            // Generate random data for upload
            const randomData = new Blob([new Array(1024 * 1024 * dataSizeMB).fill('0').join('')], { type: 'text/plain' });

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/upload-test', true);  // Use a real backend endpoint for upload testing
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const endTime = new Date().getTime();
                    const timeTakenInSeconds = (endTime - startTime) / 1000;
                    const uploadSpeedMbps = (dataSizeMB * 8) / timeTakenInSeconds;
                    document.getElementById('uploadSpeed').innerText = `Upload Speed: ${uploadSpeedMbps.toFixed(2)} Mbps`;
                }
            };

            xhr.onerror = function () {
                document.getElementById('uploadSpeed').innerText = 'Error testing upload speed.';
            };

            xhr.send(randomData);  // Upload the random data
        }
    </script>
</head>
<body>
    <h1>Internet Speed Test</h1>

    <button onclick="startDownloadTest()">Start Download Speed Test</button>
    <p id="downloadSpeed"></p>

    <button onclick="startUploadTest()">Start Upload Speed Test</button>
    <p id="uploadSpeed"></p>
</body>
</html>
