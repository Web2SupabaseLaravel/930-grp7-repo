
import ClinicsSlider from "./components/shuroq/Slider/ClinicsSlider";
import Navbar from "./components/shuroq/Navbar/Navbar";
import FeaturesSection from "./components/shuroq/Features/FeaturesSection";
import BookAppointment from "./components/shuroq/Booking/BookAppointment";
function App() {
  
  return (
    <div>
      <Navbar />
         <img
         src="/assets/hero.png" alt="hero"className="hero-image"
        />

      <ClinicsSlider />
        <BookAppointment />
      <FeaturesSection />
    
    </div>
  );
}

export default App;
