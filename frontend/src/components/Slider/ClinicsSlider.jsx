
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "./slider.css";

const clinics = [
  { name: "جلدية", img: "/images/skin.png" },
  { name: "نفسي", img: "/images/psych.png" },
  { name: "اسنان", img: "/images/dentist.png" },
  { name: "اطفال", img: "/images/kids.png" },
  { name: "عيون", img: "/images/eye.png" },
  { name: "عظام", img: "/images/bones.png" },
  { name: "باطنية", img: "/images/internal.png" },
  { name: "أنف وأذن", img: "/images/ent.png" },
];

export default function ClinicsSlider() {
  return (
    <div style={{ direction: "rtl", textAlign: "center", padding: "20px" }}>
   <h2 className="clinic-title">العيادات</h2>

      <Swiper
        modules={[Navigation]}
        spaceBetween={20}
        slidesPerView={4}
        navigation
        loop={true}
      >
        {clinics.map((clinic, idx) => (
          <SwiperSlide key={idx}>
            <div className="clinic-card">
              <img src={clinic.img} alt={clinic.name} />
              <p>{clinic.name}</p>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
  );
}