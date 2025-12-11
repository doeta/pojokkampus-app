// Seller Dashboard Charts (SRS-MartPlace-08)
function initSellerCharts(chartData) {
    if (!chartData) {
        console.error("Chart data not provided");
        return;
    }

    // Chart Colors (Purple theme for seller)
    const multiColors = [
        "rgba(147, 51, 234, 0.7)", // Purple
        "rgba(59, 130, 246, 0.7)", // Blue
        "rgba(16, 185, 129, 0.7)", // Green
        "rgba(245, 158, 11, 0.7)", // Yellow
        "rgba(239, 68, 68, 0.7)", // Red
        "rgba(236, 72, 153, 0.7)", // Pink
        "rgba(99, 102, 241, 0.7)", // Indigo
        "rgba(20, 184, 166, 0.7)", // Teal
        "rgba(249, 115, 22, 0.7)", // Orange
        "rgba(107, 114, 128, 0.7)", // Gray
    ];

    // 1. Stock Distribution per Product Chart
    const stockByProductCtx = document.getElementById("stockByProductChart");
    if (stockByProductCtx) {
        new Chart(stockByProductCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.stockProductNames,
                datasets: [
                    {
                        label: "Stok Tersedia",
                        data: chartData.stockProductValues,
                        backgroundColor: "rgba(147, 51, 234, 0.2)",
                        borderColor: "rgba(147, 51, 234, 1)",
                        borderWidth: 2,
                        borderRadius: 4,
                        barPercentage: 0.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: "rgba(255, 255, 255, 0.9)",
                        titleColor: "#1f2937",
                        bodyColor: "#4b5563",
                        borderColor: "#e5e7eb",
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "#f3f4f6",
                        },
                        ticks: {
                            font: {
                                size: 11,
                            },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            font: {
                                size: 11,
                            },
                        },
                    },
                },
            },
        });
    }

    // 2. Rating Distribution per Product Chart
    const ratingByProductCtx = document.getElementById("ratingByProductChart");
    if (ratingByProductCtx) {
        new Chart(ratingByProductCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.ratingProductNames,
                datasets: [
                    {
                        label: "Rating Rata-rata",
                        data: chartData.ratingProductValues,
                        backgroundColor: "rgba(245, 158, 11, 0.2)",
                        borderColor: "rgba(245, 158, 11, 1)",
                        borderWidth: 2,
                        borderRadius: 4,
                        barPercentage: 0.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: "y",
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: "rgba(255, 255, 255, 0.9)",
                        titleColor: "#1f2937",
                        bodyColor: "#4b5563",
                        borderColor: "#e5e7eb",
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 5,
                        grid: {
                            color: "#f3f4f6",
                        },
                    },
                    y: {
                        grid: {
                            display: false,
                        },
                    },
                },
            },
        });
    }

    // 3. Store Rating Distribution Chart (SRS-MartPlace-08)
    const storeRatingCtx = document.getElementById("storeRatingChart");
    if (storeRatingCtx) {
        new Chart(storeRatingCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.storeRatingLabels.map((l) => l + " Bintang"),
                datasets: [
                    {
                        label: "Jumlah Review",
                        data: chartData.storeRatingValues,
                        backgroundColor: [
                            "rgba(16, 185, 129, 0.7)", // 5 Stars - Green
                            "rgba(132, 204, 22, 0.7)", // 4 Stars - Lime
                            "rgba(250, 204, 21, 0.7)", // 3 Stars - Yellow
                            "rgba(249, 115, 22, 0.7)", // 2 Stars - Orange
                            "rgba(239, 68, 68, 0.7)", // 1 Star - Red
                        ],
                        borderColor: [
                            "rgba(16, 185, 129, 1)",
                            "rgba(132, 204, 22, 1)",
                            "rgba(250, 204, 21, 1)",
                            "rgba(249, 115, 22, 1)",
                            "rgba(239, 68, 68, 1)",
                        ],
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: "rgba(255, 255, 255, 0.9)",
                        titleColor: "#1f2937",
                        bodyColor: "#4b5563",
                        borderColor: "#e5e7eb",
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "#f3f4f6",
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11,
                            },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            font: {
                                size: 11,
                            },
                        },
                    },
                },
            },
        });
    }
}

// Auto-init when DOM is ready - reads data from HTML data attributes
function loadSellerChartDataFromDOM() {
    const dataElement = document.getElementById("sellerChartData");
    if (!dataElement) {
        console.error("Seller chart data element not found");
        return;
    }

    try {
        const chartData = {
            stockProductNames: JSON.parse(
                dataElement.dataset.stockProductNames || "[]"
            ),
            stockProductValues: JSON.parse(
                dataElement.dataset.stockProductValues || "[]"
            ),
            ratingProductNames: JSON.parse(
                dataElement.dataset.ratingProductNames || "[]"
            ),
            ratingProductValues: JSON.parse(
                dataElement.dataset.ratingProductValues || "[]"
            ),
            storeRatingLabels: JSON.parse(
                dataElement.dataset.storeRatingLabels || "[]"
            ),
            storeRatingValues: JSON.parse(
                dataElement.dataset.storeRatingValues || "[]"
            ),
        };

        initSellerCharts(chartData);
    } catch (error) {
        console.error("Error parsing seller chart data:", error);
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", loadSellerChartDataFromDOM);
} else {
    loadSellerChartDataFromDOM();
}
