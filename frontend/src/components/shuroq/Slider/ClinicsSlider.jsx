
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "./slider.css";

const clinics = [
  { name: "جلدية", img: "/assets/skin.png" },
  { name: "نفسي", img: "/assets/psych.png" },
  { name: "اسنان", img: "/assets/dentist.png" },
  { name: "اطفال", img: "/assets/kids.png" },
  { name: "عيون", img: "/assets/eye.png" },
  { name: "عظام", img: "/assets/bones.png" },
  { name: "باطنية", img: "/assets/internal.png" },
  { name: "أنف وأذن", img: "/assets/ent.png" },
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
