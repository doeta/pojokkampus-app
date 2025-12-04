// Seller Dashboard Charts (SRS-MartPlace-08)
function initSellerCharts(chartData) {
    if (!chartData) {
        console.error("Chart data not provided");
        return;
    }

    // Chart Colors (Purple theme for seller)
    const colors = [
        "#9333ea",
        "#a855f7",
        "#c084fc",
        "#d8b4fe",
        "#e9d5ff",
        "#6366f1",
        "#818cf8",
        "#a5b4fc",
        "#c7d2fe",
        "#e0e7ff",
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
                        backgroundColor: colors[0],
                        borderColor: colors[1],
                        borderWidth: 1,
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
                    title: {
                        display: true,
                        text: "Top 10 Produk dengan Stok Terbanyak",
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
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
                        backgroundColor: colors[5],
                        borderColor: colors[6],
                        borderWidth: 1,
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
                    title: {
                        display: true,
                        text: "Top 10 Produk dengan Rating Tertinggi",
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 0.5,
                        },
                    },
                },
            },
        });
    }

    // 3. Review Distribution per Product Chart (SRS-06)
    const ratingsByProvinceCtx = document.getElementById(
        "ratingsByProvinceChart"
    );
    if (ratingsByProvinceCtx) {
        new Chart(ratingsByProvinceCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: chartData.reviewProductNames,
                datasets: [
                    {
                        label: "Jumlah Review",
                        data: chartData.reviewProductValues,
                        backgroundColor: colors[0],
                        borderColor: colors[1],
                        borderWidth: 1,
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
                    title: {
                        display: true,
                        text: "Produk dengan Review Terbanyak",
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
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
            reviewProductNames: JSON.parse(
                dataElement.dataset.reviewProductNames || "[]"
            ),
            reviewProductValues: JSON.parse(
                dataElement.dataset.reviewProductValues || "[]"
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
